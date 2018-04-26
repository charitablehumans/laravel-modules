<?php

namespace Modules\Terms\Traits;

use redzjovi\php\JsonHelper;
use Modules\Termmetas\Models\Termmetas;

trait TermmetasTrait
{
    public function getTermmetaByKey($key)
    {
        return $this->getTermmetas()->firstWhere('key', $key) ? $this->getTermmetas()->firstWhere('key', $key) : new Termmetas;
    }

    public function getTermmetas()
    {
        return \Cache::remember('terms-termmetas-'.$this->id, 1440, function () {
            return $this->termmetas;
        });
    }

    public function getTermmetaValue($key, $default = false)
    {
        // 1. From database
        $values = $this->getTermmetaValues($key);

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

    public function getTermmetaValues($key, $type = false)
    {
        $values = [];

        // 1. From database
        if ($this->id) {
            if ($this->getTermmetaByKey($key)->value) {
                $values = $this->getTermmetaByKey($key)->value;
                $values = JsonHelper::isValidJson($values) ? json_decode($values, true) : $values;
            }
        }

        // 2. From request old
        $values = is_array(request()->old('termmetas.'.$key)) ? request()->old('termmetas.'.$key) : $values;

        return $values;
    }

    // DEPRECATED, and will be REMOVED soon
    public function getTermmetaNestable()
    {
        // $this->nestable = [];
        // $this->nestable = $this->id && isset($this->termmetas->where('key', 'nestable')->first()->value) ? json_decode($this->termmetas->where('key', 'nestable')->first()->value, true) : $this->nestable;
        // $this->nestable = is_array(request()->old('termmetas.nestable')) ? request()->old('termmetas.nestable') : $this->nestable;
        // return $this->nestable;
        return $this->getTermmetaValues('nestable');
    }
}
