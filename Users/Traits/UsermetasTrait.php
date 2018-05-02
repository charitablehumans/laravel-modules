<?php

namespace Modules\Users\Traits;

use redzjovi\php\JsonHelper;
use Modules\Usermetas\Models\Usermetas;

trait UsermetasTrait
{
    public function getUsermetaByKey($key)
    {
        return $this->getUsermetas()->firstWhere('key', $key) ? $this->getUsermetas()->firstWhere('key', $key) : new Usermetas;
    }

    public function getUsermetas()
    {
        return \Cache::remember('users-usermetas-'.$this->id, 1440, function () {
            return $this->usermetas;
        });
    }

    public function getUsermetaValueByKey($key, $default = false)
    {
        // 1. From database
        $values = $this->getUsermetaValuesByKey($key);

        // 2. Collect first value
        $value = collect($values)->first();

        // 3. Check default
        if (empty($value) && $default) {
            if (in_array($key, ['attached_file', 'attached_file_thumbnail'])) {
                $value = 'images/posts/default.png';
            }
        }

        return $value;
    }

    public function getUsermetaValuesByKey($key)
    {
        $values = [];

        // 1. From database
        if ($this->id) {
            if ($this->getUsermetaByKey($key)->value) {
                $values = $this->getUsermetaByKey($key)->value;
                $values = JsonHelper::isValidJson($values) ? json_decode($values, true) : $values;
            }
        }

        // 2. From request old
        $values = is_array(\Request::old('usermetas.'.$key)) ? \Request::old('usermetas.'.$key) : $values;

        return $values;
    }
}
