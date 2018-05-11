<?php

namespace Modules\Tags\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Terms\Models\Terms;

class Tags extends Terms
{
    protected $attributes = ['taxonomy' => 'tag'];

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'tag'); });
    }
}
