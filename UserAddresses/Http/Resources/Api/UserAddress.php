<?php

namespace Modules\UserAddresses\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class UserAddress extends Resource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'province_id' => $this->province_id,
            'regency_id' => $this->regency_id,
            'district_id' => $this->district_id,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'primary' => (int) $this->primary,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
