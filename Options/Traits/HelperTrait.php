<?php

namespace Modules\Options\Traits;

trait HelperTrait
{
    public static function getByName($name)
    {
        return \Cache::remember((new self)->getTable().'-name-'.$name, 1440, function () use ($name) {
            return self::where('name', $name)->first();
        });
    }

    // DEPRECATED, and will be REMOVED soon
    public static function getOptionByName($name)
    {
        return self::getByName($name);
    }
}
