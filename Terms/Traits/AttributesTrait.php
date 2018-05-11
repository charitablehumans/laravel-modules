<?php

namespace Modules\Terms\Traits;

trait AttributesTrait
{
    public function getIdNameOptions()
    {
        return self::select([self::getTable().'.id', 'name'])->search(['sort' => 'name:asc'])->get()->pluck('name', 'id')->toArray();
    }
}
