<?php

namespace Modules\DokuMyshortcart\Models;

use Illuminate\Database\Eloquent\Model;

class DokuMyshortcartTransactionLogs extends Model
{
    protected $fillable = [
        // 'id',
        'ip_address',
        'type',
        'TRANSIDMERCHANT',
        'STOREID',

        'AMOUNT',
        'WORDS',
        'RESULT',
        'STATUSCODE',
        'TRANSDATE',

        'PTYPE',
        'EXTRAINFO',
        'data',
    ];

    protected $table = 'doku_myshortcart_transaction_logs';

    public function createLog($data)
    {
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['data'] = json_encode($data);
        self::create($data);
    }
}
