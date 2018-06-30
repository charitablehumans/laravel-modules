<?php

namespace Modules\PostProducts\Traits;

trait AttributesTrait
{
    public function getSpecialSellPriceDiscount()
    {
        return $this->sell_price - $this->special_sell_price;
    }

    public function getSpecialSellPriceDiscountPercentage()
    {
        return ($this->sell_price - $this->special_sell_price) / $this->sell_price * 100;
    }

    public function getStatus()
    {
        return \Request::old('status', $this->status);
    }

    public function getStatusOptions()
    {
        return [
            'always_available' => trans('cms::cms.always_available'),
            'limited_stock' => trans('cms::cms.limited_stock'),
        ];
    }

    public function getStock()
    {
        $stock = $this->getStatus() == 'always_available' ? 999999999 : $this->stock;
        return \Request::old('stock', $stock);
    }

    public function getStockUnlimited()
    {
        return $this->getStatus() == 'always_available' ? '&#8734;' : '';
    }

    public function getWeight()
    {
        return (int) \Request::old('weight', $this->weight);
    }
}
