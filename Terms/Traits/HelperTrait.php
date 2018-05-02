<?php

namespace Modules\Terms\Traits;

trait HelperTrait
{
    public static function getTermById($id)
    {
        return \Cache::remember('terms-'.$id, 1440, function () use ($id) {
            return self::findOrFail($id);
        });
    }

    public static function getTermByName($name)
    {
        return \Cache::remember('terms-name-'.$name, 1440, function () use ($name) {
            return self::search(['name' => $name])->firstOrFail();
        });
    }
}
