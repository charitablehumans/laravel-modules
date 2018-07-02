<?php

namespace Modules\CartDetails\Traits;

use Modules\Products\Models\Products;

trait AttributesTrait
{
    public function getProduct()
    {
        return \Cache::remember((new Products)->getTable().'-'.$this->post_id, 1440, function () {
            return $this->product ? $this->product : new Products;
        });
    }
}
