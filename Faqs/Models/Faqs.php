<?php

namespace Modules\Faqs\Models;

use Illuminate\Database\Eloquent\Builder;

class Faqs extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'faq',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'faq'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend faqs trash') ?: $builder->where('status', '<>', 'trash'); });
    }
}
