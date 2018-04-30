<?php

namespace Modules\Posts\Traits;

trait HelperTrait
{
    public static function getPostById($id)
    {
        return \Cache::remember('posts-'.$id, 1440, function () use ($id) {
            return self::findOrFail($id);
        });
    }

    public static function getPostByName($name)
    {
        return \Cache::remember('posts-name-'.$name, 1440, function () use ($name) {
            return self::search(['name' => $name])->firstOrFail();
        });
    }
}
