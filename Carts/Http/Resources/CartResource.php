<?php

namespace Modules\Carts\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CartResource extends Resource
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
            'user_id' => (int) $this->user_id,
            'type' => $this->type,
            'total_quantity' => (int) $this->total_quantity,
            'total_price' => (int) $this->total_price,
            'total_weight' => (int) $this->total_weight,

            'cart_details' => \Modules\CartDetails\Http\Resources\CartDetailResource::collection($this->cartDetails),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
