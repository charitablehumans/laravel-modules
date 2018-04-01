<?php

namespace Modules\CustomLinks\Models;

use Illuminate\Database\Eloquent\Builder;

class CustomLinks extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'custom_link',
        'status' => 'publish'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'custom_link'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend custom links trash') ?: $builder->where('status', '<>', 'trash'); });
    }
}
