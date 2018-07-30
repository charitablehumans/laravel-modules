<?php

namespace Modules\Transactions\Observers;

use Modules\Transactions\Models\Transactions;

class TransactionObserver
{
    protected $original;

    public function saving(Transactions $transaction)
    {
        $this->original = $transaction->getOriginal();
    }

    public function saved(Transactions $transaction)
    {
        if ($transaction->status == Transactions::$statusReceived && $transaction->status <> $this->original['status']) {
            // send email received to receiver
        }
    }
}
