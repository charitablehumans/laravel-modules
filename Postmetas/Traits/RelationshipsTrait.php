<?php

namespace Modules\Postmetas\Traits;

use Modules\Media\Models\Media;
use redzjovi\php\JsonHelper;

trait RelationshipsTrait
{
    public function getMedia()
    {
        $values = JsonHelper::isValidJson($this->value) ? json_decode($this->value, true) : [];

        $media = [];
        foreach ($values as $value) {
            $media[] = $value ? Media::getPostById($value) : new Media;
        }

        return $media;
    }

    public function getMediaUrlFullByKey($key, $default = false)
    {
        $values = JsonHelper::isValidJson($this->value) ? json_decode($this->value, true) : [];

        $mediaUrl = [];
        foreach ($values as $value) {
            $mediaUrl[] = \Storage::url(Media::getPostById($value)->getPostmetaValue($key, true));
        }

        return $mediaUrl;
    }

    public function getMedium()
    {
        $values = JsonHelper::isValidJson($this->value) ? json_decode($this->value, true) : $this->value;
        $value = collect($values)->first();
        $medium = $value ? Media::getPostById($value) : new Media;
        return $medium;
    }
}
