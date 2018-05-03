<?php

namespace Modules\Products\Traits;

use Modules\PostProducts\Models\PostProducts;

trait AttributesTrait
{
    public function getPostProduct()
    {
        return \Cache::remember('posts-post_products-post_id-'.$this->id, 1440, function () {
            return $this->id ? $this->postProduct : new PostProducts;
        });
    }

    public function getPostProductSellPrice()
    {
        $postProductSellPrice = 0;
        $postProductSellPrice = $this->id && $this->getPostProduct() ? $this->getPostProduct()->sell_price : $postProductSellPrice;
        return \Request::old('post_products.sell_price', $postProductSellPrice);
    }

    public function getPostProductSpecialSell()
    {
        $postProductSpecialSell = 0;
        $postProductSpecialSell = $this->id && $this->getPostProduct() ? $this->getPostProduct()->special_sell : $postProductSpecialSell;
        return \Request::old('post_products.special_sell', $postProductSpecialSell);
    }

    public function getPostProductSpecialSellPrice()
    {
        $postProductSpecialSellPrice = 0;
        $postProductSpecialSellPrice = $this->id && $this->getPostProduct() ? $this->getPostProduct()->special_sell_price : $postProductSpecialSellPrice;
        return \Request::old('post_products.special_sell_price', $postProductSpecialSellPrice);
    }

    public function getPostProductStatus()
    {
        $postProductStatus = 'always_available';
        $postProductStatus = $this->id && $this->getPostProduct() ? $this->getPostProduct()->status : $postProductStatus;
        return \Request::old('post_products.status', $postProductStatus);
    }

    public function getPostProductStatusOptions()
    {
        return (new PostProducts)->getStatusOptions();
    }

    public function getPostProductStock()
    {
        $postProductStock = 0;
        $postProductStock = $this->id && $this->getPostProduct() ? $this->getPostProduct()->stock : $postProductStock;
        return \Request::old('post_products.stock', $postProductStock);
    }

    public function getPostProductWeight()
    {
        $postProductWeight = 0;
        $postProductWeight = $this->id && $this->getPostProduct() ? $this->getPostProduct()->weight : $postProductWeight;
        return \Request::old('post_products.weight', $postProductWeight);
    }
}
