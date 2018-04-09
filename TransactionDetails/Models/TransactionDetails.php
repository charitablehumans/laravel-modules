<?php

namespace Modules\TransactionDetails\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $fillable = [
        // 'id',
        'transaction_id',
        'quantity',
        'product_id',
        'product_sell_price',

        'product_discount',
        'product_weight',
    ];

    protected $table = 'transaction_details';

    public function product()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'product_id');
    }
}
