<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasMeta
{
    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class, 'attachable');
    }
}
