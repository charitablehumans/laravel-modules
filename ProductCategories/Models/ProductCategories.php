<?php

namespace Modules\ProductCategories\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Terms\Models\Terms;

class ProductCategories extends Terms
{
    protected $attributes = ['taxonomy' => 'product_category'];

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'product_category'); });
    }
}