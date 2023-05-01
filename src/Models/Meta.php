<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Meta extends Model
{
    use HasFactory, HasUser;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function (Meta $field) {
            $field->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function (Meta $field) {
            $field->attachment()->delete();
        });
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
