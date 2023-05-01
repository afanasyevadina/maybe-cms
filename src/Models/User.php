<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends \App\Models\User
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
