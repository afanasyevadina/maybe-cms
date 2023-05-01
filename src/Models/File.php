<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory, HasUser;

    protected static function booted()
    {
        static::created(function(File $file) {
            $file->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::saved(function(File $file) {
            static::withoutEvents(function () use ($file) {
                if($requestFile = request()->file('file')) {
                    if($file->physicalPath && file_exists($file->physicalPath)) unlink($file->physicalPath);
                    $file->update([
                        'path' => $requestFile->store('attachments/' . date('Y') . '/' . date('m') . '/' . date('d')),
                        'mime' => $requestFile->getMimeType(),
                        'original_name' => $requestFile->getClientOriginalName(),
                        'disk' => 'public',
                        'size' => $requestFile->getSize(),
                    ]);
                }
            });
        });

        static::deleting(function(File $file) {
            if($file->physicalPath && file_exists($file->physicalPath)) unlink($file->physicalPath);
        });
    }

    protected $guarded = [];

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function getPhysicalPathAttribute(): ?string
    {
        return $this->path ? public_path('storage/' . $this->path) : null;
    }

    public function getAssetPathAttribute(): ?string
    {
        return $this->path ? asset('storage/' . $this->path) : null;
    }
}
