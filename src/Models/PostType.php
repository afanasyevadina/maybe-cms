<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PostType extends Model
{
    use HasFactory, HasUser;

    protected $guarded = [];

    protected $casts = [
        'structure' => 'array',
    ];

    protected static function booted()
    {
        static::created(function (PostType $model) {
            $model->update([
                'user_id' => auth()->id(),
                'slug' => Str::plural(create_slug($model)),
                'plural_title' => $model->title,
            ]);
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function relations(): HasMany
    {
        return $this->hasMany(Relation::class);
    }

    public function inverseRelations(): HasMany
    {
        return $this->hasMany(Relation::class, 'related_post_type_id');
    }
}
