<?php

namespace Modules\MediumCategories\Models;

class MediumCategories extends \Modules\Terms\Models\Terms
{
    protected $attributes = ['taxonomy' => 'medium_category'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \Modules\Terms\Scopes\TaxonomyScope);
    }
}
