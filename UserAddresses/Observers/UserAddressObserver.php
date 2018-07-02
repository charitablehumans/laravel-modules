<?php

namespace Modules\UserAddresses\Observers;

use Modules\UserAddresses\Models\UserAddresses;

class UserAddressObserver
{
    public function saved(UserAddresses $model)
    {
        \Cache::forget($model->getTable().'-user_id-'.$model->user_id);
    }

    public function deleted(UserAddresses $model)
    {
        \Cache::forget($model->getTable().'-user_id-'.$model->user_id);
    }
}
