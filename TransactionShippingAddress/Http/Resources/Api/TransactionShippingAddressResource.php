<?php

namespace Modules\TransactionShippingAddress\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class TransactionShippingAddressResource extends Resource
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
            'id' => (int) $this->id,
            'transaction_id' => (int) $this->transaction_id,
            'phone_number' => $this->phone_number,
            'province_id' => (int) $this->province_id,
            'province' => $this->province,
            'regency_id' => (int) $this->regency_id,
            'regency' => $this->regency,
            'district_id' => (int) $this->district_id,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
