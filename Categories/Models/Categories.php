<?php

namespace Modules\Categories\Models;

class Categories extends \Modules\Terms\Models\Terms
{
    protected $attributes = ['taxonomy' => 'category'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \Modules\Terms\Scopes\TaxonomyScope);
    }
}
