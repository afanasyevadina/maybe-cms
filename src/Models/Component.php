<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory, HasUser, HasBlocks;

    protected static function booted()
    {
        static::created(function(Component $component) {
            $component->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function (Component $component) {
            foreach ($component->blocks as $block) $block->delete();
        });
    }

    protected $guarded = [];
}
