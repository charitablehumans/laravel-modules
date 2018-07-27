<?php

namespace Modules\TransactionShipment\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Transactions\Models\Transactions;

class TransactionShipment extends Model
{
    public static $codeJne = 'jne';
    public static $codeRpx = 'rpx';

    protected $fillable = [
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
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }
}
