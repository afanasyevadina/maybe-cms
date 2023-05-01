<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasBlocks
{
    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
    }

    public function updateBlocks(array $data): void
    {
        foreach ($data ?? [] as $item) {
            $block = $this->blocks()->findOrFail($item['id']);
            $block->updateContent(collect($item)->only(['title', 'order', 'post_type_id', 'content'])->toArray());
            $block->updateBlocks($item['blocks'] ?? []);
        }
    }

    public function updateContent(array $data)
    {
        $attachmentIds = [];
        foreach ($data['content'] ?? [] as $contentItem) {
            if (@$contentItem['attachment']['file']['id']) {
                $attachment = $this->attachments()->updateOrCreate(['role' => $contentItem['slug']], ['file_id' => File::query()->findOrFail($contentItem['attachment']['file']['id'])->id]);
                if (@$contentItem['attachment']['poster']['file']['id']) {
                    $attachment->poster()->updateOrCreate([], ['file_id' => File::query()->findOrFail($contentItem['attachment']['poster']['file']['id'])->id, 'role' => 'poster']);
                } else {
                    $attachment->poster()->delete();
                }
                $attachmentIds[] = $attachment->id;
            }
        }
        foreach ($this->attachments()->whereNotIn('id', $attachmentIds)->get() as $unusedAttachment) {
            $unusedAttachment->delete();
        }
        $data['content'] = collect($data['content'] ?? [])->map(fn($item) => [
            $item['slug'] => [
                'value' => $item['value'],
                ...@$item['source'] ? ['source' => $item['source']] : [],
            ],
        ])->collapse();
        $this->update($data);
    }

    public function appendBlocks($blocks): Collection
    {
        return collect($blocks ?? [])->map(function (Block $block) {
            $childBlock = $this->blocks()->create([
                'type' => $block->type ?? '',
                'title' => $block->title ?? '',
                'content' => $block->content ?? [],
                'post_type_id' => $block->post_type_id,
                'component_id' => $block->component_id,
            ]);
            foreach ($block->attachments as $attachment) {
                $childBlock->attachments()->create([
                    'file_id' => $attachment->file_id,
                    'role' => $attachment->role,
                    'alt' => $attachment->alt,
                ]);
            }
            $childBlock->appendBlocks($block->blocks ?? []);
            return $childBlock;
        });
    }

    /**
     * @param int|null $postTypeId
     * @return void
     */
    public function setPostType(?int $postTypeId): void
    {
        $this->update(['post_type_id' => $postTypeId]);
        foreach ($this->blocks as $block) {
            $block->setPostType($postTypeId);
        }
    }
}
