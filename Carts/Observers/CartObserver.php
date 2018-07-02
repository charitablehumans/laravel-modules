<?php

namespace Modules\Carts\Observers;

use Modules\CartDetails\Models\CartDetails;
use Modules\Carts\Models\Carts;

class CartObserver
{
    public $cartDetails;

    public function __construct()
    {
        $this->cartDetails = new CartDetails;
    }

    public function saved(Carts $model)
    {
        \Cache::forget($model->getTable().'-user_id-'.$model->user_id);
        \Cache::forget($this->cartDetails->getTable().'-cart_id-'.$model->id);
    }

    public function deleted(Carts $model)
    {
        \Cache::forget($model->getTable().'-user_id-'.$model->user_id);
        \Cache::forget($this->cartDetails->getTable().'-cart_id-'.$model->id);
    }
}
