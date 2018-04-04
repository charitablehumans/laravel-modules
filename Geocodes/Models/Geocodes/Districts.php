<?php

namespace Modules\Geocodes\Models\Geocodes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Districts extends \Modules\Geocodes\Models\Geocodes
{
    protected $attributes = [
        'type' => 'district',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'district'); });
    }
}
