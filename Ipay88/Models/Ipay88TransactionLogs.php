<?php

namespace Modules\Ipay88\Models;

use Illuminate\Database\Eloquent\Model;

class Ipay88TransactionLogs extends Model
{
    protected $fillable = [
        'ip_address',
        'type',
        'MerchantCode',
        'PaymentId',

        'RefNo',
        'Amount',
        'Currency',
        'Remark',
        'TransId',

        'AuthCode',
        'Status',
        'ErrDesc',
        'Signature',
        'data',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'ipay88_transaction_logs';

    public function createLog($data)
    {
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['data'] = json_encode($data);
        $model = new self;
        $model->fill($data)->save();
        return $model;
    }

    public function getStatusIdNameOptions()
    {
        return [
            self::$statusFail => 'Fail',
            self::$statusSuccess => 'Success',
            self::$statusPending => 'Pending',
        ];
    }

    public static $statusFail = '0';

    public static $statusPending = '6';

    public static $statusSuccess = '1';
}
