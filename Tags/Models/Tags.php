<?php

namespace Modules\Tags\Models;

class Tags extends \Modules\Terms\Models\Terms
{
    protected $attributes = ['taxonomy' => 'tag'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \Modules\Terms\Scopes\TaxonomyScope);
    }
}
