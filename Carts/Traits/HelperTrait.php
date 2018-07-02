<?php

namespace Modules\Carts\Traits;

trait HelperTrait
{
    public static function getByUserId($userId)
    {
        return \Cache::remember((new self)->getTable().'-user_id-'.$userId, 1440, function () use ($userId) {
            return self::where('user_id', $userId)->first();
        });
    }
}
