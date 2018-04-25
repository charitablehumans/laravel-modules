<?php

namespace Modules\Pages\Traits;

use Modules\Pages\Models\Pages;

trait HelperTrait
{
    public static function getPostById($id)
    {
        return \Cache::remember('posts-'.$id, 1440, function () use ($id) {
            return Pages::find($id);
        });
    }

    public static function getPostByName($name)
    {
        return \Cache::remember('posts-name-'.$name, 1440, function () use ($name) {
            return Pages::search(['name' => $name])->first();
        });
    }
}
