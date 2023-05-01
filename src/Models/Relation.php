<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Relation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function (Relation $relation) {
            static::withoutEvents(fn() => create_slug($relation));
        });

        static::deleting(function (Relation $relation) {
            $relation->posts()->detach();
            $relation->inversePosts()->detach();
        });
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post', 'relation_id', 'related_post_id')->withTimestamps();
    }

    public function inversePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post', 'relation_id', 'post_id')->withTimestamps();
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(\Altenic\MaybeCms\Models\PostType::class)->withDefault();
    }

    public function relatedPostType(): BelongsTo
    {
        return $this->belongsTo(\Altenic\MaybeCms\Models\PostType::class, 'related_post_type_id')->withDefault();
    }
}
