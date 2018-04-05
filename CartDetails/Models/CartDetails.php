<?php

namespace Modules\CartDetails\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Models\Products;

class CartDetails extends Model
{
    protected $attributes = [
        'seller_id' => 0,
        'weight' => 0,
    ];

    protected $fillable = [
        'cart_id', 'seller_id', 'post_id', 'quantity', 'price',
        'weight',
    ];

    protected $table = 'cart_details';

    /**
     * @param array $data
     * [
     *      'post_id' => 1,
     *      'quantity' => 1,
     * ]
     * @param [type] $cartId
     */
    public function insertUpdate($data = [], $cartId)
    {
        $product = Products::findOrFail($data['post_id']);

        $cartDetail = self::firstOrNew(['cart_id' => $cartId, 'post_id' => $product->id]);
        $cartDetail->quantity += $data['quantity'];
        $cartDetail->price = $product->getPostProductSellPrice();
        $cartDetail->weight = $product->getPostProductWeight();
        $cartDetail->save();
    }

    public function product()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'post_id');
    }

    public function sync($cartId)
    {
        if ($cartDetails = self::where('cart_id', $cartId)->get()) {
            foreach ($cartDetails as $cartDetail) {
                $product = Products::findOrFail($cartDetail->post_id);

                $cartDetail->price = $product->getPostProductSellPrice();
                $cartDetail->weight = $product->getPostProductWeight();
                $cartDetail->save();
            }
        }
    }
}
