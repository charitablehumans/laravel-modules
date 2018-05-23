<?php

namespace Modules\Terms\Traits;

trait HelperTrait
{
    public static function getById($id)
    {
        return \Cache::remember((new self)->getTable().'-'.$id, 1440, function () use ($id) {
            return self::findOrFail($id);
        });
    }

    public static function getBySlug($slug)
    {
        return \Cache::remember((new self)->getTable().'-slug-'.$slug, 1440, function () use ($slug) {
            return self::search(['slug' => $slug])->firstOrFail();
        });
    }
}
