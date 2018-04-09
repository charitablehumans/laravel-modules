<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

class PostProducts extends Model
{
    protected $fillable = [
        'post_id',
        'status',
        'stock',
        'sell_price',
        'weight',
    ];

    protected $table = 'post_products';

    public function getSellPrice()
    {
        $sellPrice = $this->sell_price;
        $sellPrice = request()->old('post_products.sell_price') ? request()->old('post_products.sell_price') : $sellPrice;
        return (int) $sellPrice;
    }

    public function getStatus()
    {
        $status = $this->status;
        $status = is_array(request()->old('post_products.status')) ? request()->old('post_products.status') : $status;
        return $status;
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
        $stock = request()->old('post_products.stock') ? request()->old('post_products.stock') : $stock;
        return (int) $stock;
    }

    public function getStockUnlimited()
    {
        return $this->getStatus() == 'always_available' ? '&#8734;' : '';
    }

    public function getWeight()
    {
        $weight = $this->weight;
        $weight = request()->old('post_products.weight') ? request()->old('post_products.weight') : $weight;
        return (int) $weight;
    }

    public function product()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'post_id');
    }

    public function sync($data, $postId)
    {
        $postLocation = self::firstOrCreate(['post_id' => $postId]);
        $postLocation->fill($data);
        $postLocation->save();
    }
}
