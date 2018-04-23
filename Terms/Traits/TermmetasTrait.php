<?php

namespace Modules\Terms\Traits;

use redzjovi\php\JsonHelper;
use Modules\Media\Models\Media;

trait TermmetasTrait
{
    public function getTermmetas()
    {
        return \Cache::remember('terms-termmetas-'.$this->id, 1440, function () {
            return $this->termmetas;
        });
    }

    public function getTermmetaValue($key, $type = false)
    {
        // 1. From database
        $values = $this->getTermmetaValues($key, $type);

        // 2. Collect first value
        $value = collect($values)->count() > 0 ? collect($values)->first() : false;

        // 3. Transform based on type
        if (empty($value) && in_array($type, ['image_thumbnail_url', 'image_url'])) {
            $value = asset('images/posts/default.png');
        }

        return $value;
    }

    public function getTermmetaValues($key, $type = false)
    {
        $values = [];

        // 1. From database
        if ($this->id) {
            $termmetas = $this->getTermmetas();

            if (isset($termmetas->where('key', $key)->first()->value)) {
                $values = $termmetas->where('key', $key)->first()->value;
                $values = JsonHelper::isValidJson($values) ? json_decode($values, true) : $values;
            }
        }

        // 2. From request old
        $values = is_array(request()->old('termmetas.'.$key)) ? request()->old('termmetas.'.$key) : $values;

        // 3. Transform based on type
        if (is_array($values) && $type) {
            foreach ($values as $i => $value) {

                if ($type == 'image_thumbnail_url') {
                    $imageUrl = asset('images/posts/default.png');
                    $mediumId = $value;

                    $medium = \Cache::remember('terms-'.$mediumId, 1440, function () use ($mediumId) {
                        return Media::find($mediumId);
                    });

                    if ($medium) {
                        $imageUrl = $medium->getTermmetaValue('attached_file_thumbnail');
                        $imageUrl = \Storage::url($imageUrl);
                        $values[$i] = $imageUrl;
                    }
                } else if ($type == 'image_url') {
                    $imageUrl = asset('images/posts/default.png');
                    $mediumId = $value;

                    $medium = \Cache::remember('terms-'.$mediumId, 1440, function () use ($mediumId) {
                        return Media::find($mediumId);
                    });

                    if ($medium) {
                        $imageUrl = $medium->getTermmetaValue('attached_file');
                        $imageUrl = \Storage::url($imageUrl);
                        $values[$i] = $imageUrl;
                    }
                }

            }
        }

        return $values;
    }

    // DEPRECATED, and will be REMOVED soon
    public function getTermmetaImagesId()
    {
        // $imagesId = [];
        // $imagesId = $this->id && isset($this->termmetas->where('key', 'images')->first()->value) ? json_decode($this->termmetas->where('key', 'images')->first()->value, true) : $imagesId;
        // $imagesId = is_array(request()->old('termmetas.images')) ? request()->old('termmetas.images') : $imagesId;
        // return $imagesId;
        return $this->getTermmetaValues('images');
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

    // DEPRECATED, and will be REMOVED soon
    public function getTermmetaTemplate()
    {
        // $template = isset($this->termmetas->where('key', 'template')->first()->value) ? $this->termmetas->where('key', 'template')->first()->value : '';
        // return $template;
        return $this->getTermmetaValue('template');
    }
}
