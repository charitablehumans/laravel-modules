<?php

namespace Modules\MediumCategories\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Terms\Models\Terms;

class MediumCategories extends Terms
{
    protected $attributes = ['taxonomy' => 'medium_category'];

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'medium_category'); });
    }
}
