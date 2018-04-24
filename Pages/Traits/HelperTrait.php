<?php

namespace Modules\Pages\Traits;

trait HelperTrait
{
    public static function getPostById($id)
    {
        return \Cache::remember('posts-'.$id, 1440, function () use ($id) {
            return \Modules\Pages\Models\Pages::find($id);
        });
    }
}
