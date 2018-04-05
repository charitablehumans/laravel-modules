<?php

namespace Modules\Carts\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $attributes = [
        'type' => 'shopping',
    ];

    protected $fillable = [
        'user_id', 'type', 'total_quantity', 'total_price', 'total_weight',
    ];

    protected $table = 'carts';

    public function cartDetails()
    {
        return $this->hasMany('\Modules\CartDetails\Models\CartDetails', 'cart_id', 'id');
    }

    public function getTotalPrice()
    {
        $totalPrice = 0;

        if ($cartDetails = $this->cartDetails) {
            foreach ($cartDetails as $cartDetail) {
                $totalPrice += $cartDetail->quantity * $cartDetail->price;
            }
        }

        return $totalPrice;
    }

    public function getTotalQuantity()
    {
        $totalQuantity = 0;

        if ($cartDetails = $this->cartDetails) {
            foreach ($cartDetails as $cartDetail) {
                $totalQuantity += $cartDetail->quantity;
            }
        }

        return $totalQuantity;
    }

    public function getTotalWeight()
    {
        $totalWeight = 0;

        if ($cartDetails = $this->cartDetails) {
            foreach ($cartDetails as $cartDetail) {
                $totalWeight += $cartDetail->quantity * $cartDetail->weight;
            }
        }

        return $totalWeight;
    }

    public function sync()
    {
        $this->total_quantity = $this->getTotalQuantity();
        $this->total_price = $this->getTotalPrice();
        $this->total_weight = $this->getTotalWeight();
        return $this;
    }
}
