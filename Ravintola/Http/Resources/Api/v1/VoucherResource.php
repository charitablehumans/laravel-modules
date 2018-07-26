<?php

namespace Modules\Ravintola\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\Resource;

class VoucherResource extends Resource
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
            'id' => (string) $this->uuid,
            'code' => (string) $this->verification_number,
            'expiry' => (string) $this->expiry,
            'value' => (integer) config('ravintola.value.enabled') ? $this->value : 0,
            'used_time' => (string) $this->used_time,

            'used_time' => (string) $this->used_time,
            'used_outlet' => (string) $this->used_outlet,
            'status' => (string) $this->status,
        ];
    }
}
