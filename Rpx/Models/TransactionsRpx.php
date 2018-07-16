<?php

namespace Modules\Rpx\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionsRpx extends \Modules\Transactions\Models\Transactions
{
    public function processSendShipmentData($id, $awb)
    {
        $transaction = TransactionsRpx::where(['id' => $id, 'status' => 'processed'])->firstOrFail();
        $transaction->status = 'sent';
        $transaction->receipt_number = $awb;
        $transaction->save();
    }


}
