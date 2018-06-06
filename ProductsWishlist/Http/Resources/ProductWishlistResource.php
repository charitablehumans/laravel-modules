<?php

namespace Modules\ProductsWishlist\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductWishlistResource extends Resource
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
            'product_id' => $this->post_id, 'product' => new \Modules\Products\Http\Resources\ProductResource($this->product),
            'user_id' => $this->user_id, 'user' => new \Modules\Users\Http\Resources\UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
