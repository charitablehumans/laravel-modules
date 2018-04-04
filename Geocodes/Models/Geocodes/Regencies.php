<?php

namespace Modules\Geocodes\Models\Geocodes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Regencies extends \Modules\Geocodes\Models\Geocodes
{
    protected $attributes = [
        'type' => 'regency',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'regency'); });
    }

    public function getIdOptions($provinceId = null)
    {
        $search = [];
        $provinceId ? $search['parent_id'] = $provinceId : '';
        return self::search($search)->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
