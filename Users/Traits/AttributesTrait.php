<?php

namespace Modules\Users\Traits;

trait AttributesTrait
{
    public function getIdNameOptions()
    {
        return self::select(['id', 'name'])->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
