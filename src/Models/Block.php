<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class Block extends Model
{
    use HasFactory, HasBlocks, HasAttachments, HasUser;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'content' => 'array',
        'query' => 'array',
    ];

    protected static function booted()
    {
        static::created(function (Block $block) {
            $block->update([
                'user_id' => auth()->id(),
                'active' => 1,
                'order' => $block->attachable?->blocks()->count(),
                'content' => $block->content ?? collect($block->structure ?? [])->map(fn($item) => [
                        $item['slug'] => [
                            'value' => array_keys($item['options'] ?? [])[0] ?? '',
                        ],
                    ])->collapse(),
                'post_type_id' => $block->attachable->post_type_id,
                'query' => $block->attachable_type == Post::class ? ['id' => $block->attachable_id] : [],
            ]);
        });

        static::deleting(function (Block $block) {
            foreach ($block->blocks as $subBlock) $subBlock->delete();
            foreach ($block->attachments as $attachment) $attachment->delete();
        });

        static::deleted(function (Block $block) {
            static::withoutEvents(function () use ($block) {
                foreach ($block->attachable->blocks as $key => $relatedBlock) {
                    $relatedBlock->order = $key + 1;
                    $relatedBlock->save();
                };
            });
        });
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function getStructureAttribute()
    {
        return maybe_primitives()[$this->type]['structure'] ?? [];
    }

    public function getPosts($source = null): ?Collection
    {
        if (@$this->query['id']) return $this->postType?->posts()->where('id', $this->query['id'])->get();
        if (@$this->query['select']) return $this->postType?->posts()->get();
        if (@$this->query['relation']) {
            if (@$this->query['inverse']) return $source?->inversePosts()->wherePivot('relation_id', $this->query['relation'])->get();
            return $source?->posts()->wherePivot('relation_id', $this->query['relation'])->get();
        }
        return collect([$source]);
    }

    public function getProperty(string $slug, $source = null)
    {
        if (!@$this->content[$slug]['source'])
            return $this->content[$slug]['value'] ?? '';
        if(@$this->content[$slug]['source'] == 'title')
            return $source?->title ?? '';
        if(@$this->content[$slug]['source'] == 'link')
            return url('/' . $source?->postType->slug . '/' . $source?->slug);
        $fieldNameParts = explode('.', $this->content[$slug]['source']);
        if (count($fieldNameParts)) {
            if ($fieldNameParts[0] == 'field') {
                return $source?->content[$fieldNameParts[1]]['value'] ?? '';
            }
            if ($fieldNameParts[0] == 'relation') {
                $post = $source?->posts()->wherePivot('relation_id', @$fieldNameParts[1])->first();
            } elseif ($fieldNameParts[0] == 'inverse_relation') {
                $post = $source?->inversePosts()->wherePivot('relation_id', @$fieldNameParts[1])->first();
            }
            if(@$fieldNameParts[2] == 'title')
                return $post?->title ?? '';
            if(@$fieldNameParts[2] == 'link')
                return url('/' . $post?->postType->slug . '/' . $post?->slug);
            if (@$fieldNameParts[2] == 'field') {
                return $post?->content[@$fieldNameParts[3]]['value'] ?? '';
            }
        }
        return null;
    }

    public function getAttachment(string $slug, $source = null)
    {
        if (!@$this->content[$slug]['source'])
            return $this->attachments()->where('role', $slug)->first();
        if($fieldName = str_replace('field.', '', $this->content[$slug]['source'])) {
            return $source?->attachments()->where('role', $fieldName)->first();
        }
    }
}
