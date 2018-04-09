<?php

namespace Modules\TransactionDetails\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class TransactionDetailResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'quantity' => $this->quantity,
            'product_id' => $this->product_id,
            'product' => $this->product,

            'product_sell_price' => $this->product_sell_price,
            'product_discount' => $this->product_discount,
            'product_weight' => $this->product_weight,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
