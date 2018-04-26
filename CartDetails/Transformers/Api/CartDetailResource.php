<?php

namespace Modules\CartDetails\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class CartDetailResource extends Resource
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
            // 'cart_id' => $this->cart_id,
            'seller_id' => $this->seller_id,
            'post_id' => $this->post_id,
            'name' => $this->product ? $this->product->title : '',
            'quantity' => (int) $this->quantity,
            'price' => $this->product ? $this->product->getPostProductSellPrice() : 0,
            'weight' => $this->product ? $this->product->getPostProductWeight() : 0,
            'image_thumbnail_url' => \Storage::url($this->product->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true)),
            'image_url' => \Storage::url($this->product->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true)),

            // products
            'product' => [
                'status' => $this->product->postProduct->status,
                'stock' => $this->product->postProduct->getStock(),
                'sell_price' => $this->product->postProduct->sell_price,
                'weight' => $this->product->postProduct->weight,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
