<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;

class Setting extends Model
{
    use HasFactory, HasUser;

    protected static function booted()
    {
        static::created(function (Setting $setting) {
            $setting->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function (Setting $setting) {
            $setting->attachment()->delete();
        });
    }

    protected $guarded = [];

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function options(): array|Collection
    {
        if ($this->type != 'select') return [];
        return match ($this->slug) {
            'home_page' => Page::query()->where('active', true)->pluck('title', 'id'),
            'active_theme' => collect(scandir(public_path('vendor/maybecms/themes')))->filter(fn($item) => !in_array($item, ['.', '..']))->map(fn($item) => [$item => $item])->collapse(),
            default => [],
        };
    }
}
