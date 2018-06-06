<?php

namespace Modules\Products\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'author_id' => $this->author_id, 'author' => new \Modules\Users\Http\Resources\UserResource($this->author),
            'status' => $this->status,

            'post_product' => new \Modules\PostProducts\Http\Resources\PostProductResource($this->postProduct),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
