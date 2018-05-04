<?php

namespace Modules\Options\Traits;

use Modules\Media\Models\Media;
use Modules\Pages\Models\Pages;
use redzjovi\php\JsonHelper;

trait RelationshipsTrait
{
    public function getPageByOptionValue()
    {
        $values = JsonHelper::isValidJson($this->value) ? json_decode($this->value, true) : $this->value;
        $value = collect($values)->first();
        $page = $value ? Pages::getPostById($value) : new Pages;
        return $page;
    }
}
