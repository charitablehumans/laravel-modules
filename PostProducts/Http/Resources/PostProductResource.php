<?php

namespace Modules\PostProducts\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostProductResource extends Resource
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
            'status' => $this->status,
            'stock' => $this->stock,
            'sell_price' => $this->sell_price,
            'special_sell' => $this->special_sell,

            'special_sell_price' => $this->special_sell_price,
            'special_sell_price_discount' => $this->special_sell_price_discount,
            'special_sell_price_discount_percentage' => $this->special_sell_price_discount_percentage,
            'weight' => $this->weight,
            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
