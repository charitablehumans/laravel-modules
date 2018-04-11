<?php

namespace Modules\Users\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['phone_number'] = $this->phone_number;
        $data['access_token'] = $this->access_token;
        $data['verified'] = (int) $this->verified;
        $data['verification_code'] = $this->verification_code;
        $data['date_of_birth'] = $this->date_of_birth;
        $data['address'] = $this->address;
        \Config::get('cms.users.store_id') ? $data['store_id'] = (int) $this->store_id : '';
        \Config::get('cms.users.balance') ? $data['balance'] = (int) $this->balance : '';
        \Config::get('cms.users.game_token') ? $data['game_token'] = (int) $this->game_token : '';
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;
        return $data;
    }
}
