<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    use HasFactory, HasUser, HasBlocks;

    protected static function booted()
    {
        static::created(function(Preset $preset) {
            $preset->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function (Preset $preset) {
            foreach ($preset->blocks as $block) $block->delete();
        });
    }

    protected $guarded = [];
}
