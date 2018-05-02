<?php

namespace Modules\Users\Traits;

use Modules\Users\Models\Users;

trait AttributesTrait
{
    public function getIdNameOptions()
    {
        return Users::select(['id', 'name'])->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function getStoreIdNameOptions()
    {
        return Users::search(['role_name' => 'store', 'sort' => 'name:asc'])->get()->pluck('name', 'id');
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
