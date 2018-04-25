<?php

namespace Modules\Media\Traits;

trait HelperTrait
{
    public static function getPostById($id)
    {
        return \Cache::remember('posts-'.$id, 1440, function () use ($id) {
            return \Modules\Media\Models\Media::find($id);
        });
    }
}
