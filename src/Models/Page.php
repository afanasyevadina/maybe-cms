<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, HasBlocks, HasAttachments, HasMeta, HasUser;

    protected static function booted()
    {
        static::created(function (Page $page) {
            $page->update([
                'user_id' => auth()->id(),
                'active' => 1,
            ]);
            create_slug($page);
            $page->meta()->create();
        });

        static::deleting(function (Page $page) {
            foreach ($page->blocks as $block) $block->delete();
            if ($meta = $page->meta()->first()) $meta->delete();
        });
    }

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];
}
