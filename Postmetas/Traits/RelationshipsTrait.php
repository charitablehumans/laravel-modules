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

    public function getMedium()
    {
        $values = JsonHelper::isValidJson($this->value) ? json_decode($this->value, true) : $this->value;
        $value = collect($values)->first();
        $medium = $value ? Media::getPostById($value) : new Media;
        return $medium;
    }
}
