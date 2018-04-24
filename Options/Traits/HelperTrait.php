<?php

namespace Modules\Options\Traits;

trait HelperTrait
{
    public static function getOptionByName($name)
    {
        return \Cache::remember('options-name-'.$name, 1440, function () use ($name) {
            return \Modules\Options\Models\Options::where('name', $name)->first();
        });
    }
}
