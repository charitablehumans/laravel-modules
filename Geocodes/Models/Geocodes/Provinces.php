<?php

namespace Modules\Geocodes\Models\Geocodes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Provinces extends \Modules\Geocodes\Models\Geocodes
{
    protected $attributes = [
        'type' => 'province',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'province'); });
    }

    public function getIdOptions()
    {
        return self::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
