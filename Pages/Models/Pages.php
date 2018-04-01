<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Builder;

class Pages extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'page',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'page'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend pages trash') ?: $builder->where('status', '<>', 'trash'); });
    }
}
