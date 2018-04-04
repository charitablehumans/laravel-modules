<?php

namespace Modules\Geocodes\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class GeocodeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['type'] = $this->type;
        \Config::get('cms.geocodes.code') ? $data['code'] = $this->code : '';
        $data['name'] = $this->name;
        $data['postal_code'] = $this->postal_code;
        \Config::get('cms.geocodes.latitude') ? $data['latitude'] = $this->latitude : '';
        \Config::get('cms.geocodes.longitude') ? $data['longitude'] = $this->longitude : '';
        $data['parent_id'] = $this->parent_id;
        $data['rajaongkir_id'] = $this->rajaongkir_id;
        return $data;
    }
}
