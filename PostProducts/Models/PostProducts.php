<?php

namespace Modules\PostProducts\Models;

use Illuminate\Database\Eloquent\Model;

class PostProducts extends Model
{
    use \Modules\PostProducts\Traits\AttributesTrait;

    protected $fillable = [
        'post_id',
        'status',
        'stock',
        'sell_price',
        'special_sell',
        'special_sell_price',
        'special_sell_price_discount',
        'special_sell_price_discount_percentage',
        'weight',
    ];

    protected $table = 'post_products';

    public function product()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'post_id');
    }

    public function sync($data, $postId)
    {
        $postProduct = self::firstOrCreate(['post_id' => $postId]);
        $postProduct->fill($data);
        $postProduct->special_sell_price_discount = $postProduct->getSpecialSellPriceDiscount();
        $postProduct->special_sell_price_discount_percentage = $postProduct->getSpecialSellPriceDiscountPercentage();
        $postProduct->save();
    }
}
