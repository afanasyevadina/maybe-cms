<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
