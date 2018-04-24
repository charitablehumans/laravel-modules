<?php

namespace Modules\Posts\Traits;

trait HelperTrait
{
    public static function getPostById($id)
    {
        return \Cache::remember('posts-'.$id, 1440, function () use ($id) {
            return \Modules\Posts\Models\Posts::find($id);
        });
    }
}
