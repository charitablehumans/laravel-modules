<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Terms\Models\Terms;

class Categories extends Terms
{
    protected $attributes = ['taxonomy' => 'category'];

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'category'); });
    }
}
