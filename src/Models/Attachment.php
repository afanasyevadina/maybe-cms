<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    use HasFactory, HasUser;

    protected static function booted()
    {
        static::created(function(Attachment $attachment) {
            $attachment->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function (Attachment $attachment) {
            $attachment->poster()->delete();
        });
    }

    protected $guarded = [];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function poster(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('role', 'poster');
    }
}
