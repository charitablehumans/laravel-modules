<?php

namespace Modules\TransactionShipment\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionShipment extends Model
{
    protected $fillable = [
        // 'id',
        'transaction_id',
        'code',
        'name',
        'service',

        'description',
        'distance',
        'cost',
    ];

    protected $table = 'transaction_shipment';

    public function transaction()
    {
        return $this->belongsTo('Modules\Transactions\Models\Transactions', 'transaction_id');
    }
}
