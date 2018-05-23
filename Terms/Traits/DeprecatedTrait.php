<?php

namespace Modules\Terms\Traits;

trait DeprecatedTrait
{
    public static function getTermById($id)
    {
        return \Cache::remember('terms-'.$id, 1440, function () use ($id) {
            return self::findOrFail($id);
        });
    }

    public static function getTermBySlug($slug)
    {
        return \Cache::remember('terms-slug-'.$slug, 1440, function () use ($slug) {
            return self::search(['slug' => $slug])->firstOrFail();
        });
    }
}
