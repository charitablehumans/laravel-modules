<?php

namespace Modules\Transactions\Models\Transactions;

use Illuminate\Database\Eloquent\Builder;

class Purchases extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'purchase',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'purchase'); });
    }
}
