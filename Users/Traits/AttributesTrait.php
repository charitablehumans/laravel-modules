<?php

namespace Modules\Users\Traits;

use Modules\UserAddresses\Models\UserAddresses;
use Modules\Users\Models\Users;

trait AttributesTrait
{
    public function getNameDashEmailAttribute()
    {
        return $this->name.' - '.$this->email;
    }

    public function getGenderOptions()
    {
        return [
            'female' => trans('cms::cms.female'),
            'male' => trans('cms::cms.male'),
        ];
    }

    public function getIdNameOptions()
    {
        return Users::select(['id', 'name'])->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function getStoreIdNameOptions()
    {
        return Users::search(['role_name' => 'store', 'sort' => 'name:asc'])->get()->pluck('name', 'id');
    }

    public function getUserAddresses()
    {
        return \Cache::remember((new UserAddresses)->getTable().'-user_id-'.$this->id, 1440, function () {
            return $this->userAddresses ? $this->userAddresses : new UserAddresses;
        });
    }

    public function getVerifiedName()
    {
        $options = $this->getVerifiedOptions();
        return $options[$this->verified];
    }

    public function getVerifiedOptions()
    {
        return [
            '0' => trans('cms::cms.no'),
            '1' => trans('cms::cms.yes'),
        ];
    }
}
