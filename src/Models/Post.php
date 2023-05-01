<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, HasBlocks, HasAttachments, HasMeta, HasUser;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::created(function(Post $post) {
            $post->update([
                'user_id' => auth()->id(),
                'active' => 1,
            ]);
            create_slug($post);
            $post->meta()->create();
        });

        static::deleting(function (Post $post) {
            foreach ($post->blocks as $block) $block->delete();
            foreach ($post->attachments as $attachment) $attachment->delete();
            if ($meta = $post->meta()->first()) $meta->delete();
            $post->posts()->detach();
            $post->inversePosts()->detach();
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('post_type_id', $type);
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class)->withDefault();
    }

    public function relations()
    {
        return $this->hasManyThrough(Relation::class, PostType::class, 'id', 'post_type_id', 'post_type_id', 'id');
    }

    public function inverseRelations()
    {
        return $this->hasManyThrough(Relation::class, PostType::class, 'id', 'related_post_type_id', 'post_type_id', 'id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post', 'post_id', 'related_post_id')->withTimestamps();
    }

    public function inversePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post', 'related_post_id', 'post_id')->withTimestamps();
    }
}
