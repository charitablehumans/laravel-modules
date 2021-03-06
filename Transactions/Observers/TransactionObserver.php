<?php

namespace Modules\Transactions\Observers;

use Modules\Transactions\Models\Transactions;
use Modules\Transactions\Notifications\PaymentStatusTrue;
use Modules\Transactions\Notifications\StatusNew;
use Modules\Transactions\Notifications\StatusSent;

class TransactionObserver
{
    protected $original;

    public function saving(Transactions $transaction)
    {
        $this->original = $transaction->getOriginal();

        if ($transaction->status == Transactions::$statusNew && $transaction->status <> $this->original['status']) {
            if ($transaction->payment_status == 1) {
                // send email transaction status new, payment status true to receiver
                $transaction->receiver->notify(new PaymentStatusTrue($transaction));
            }

            // send email transaction status new to sender
            $transaction->sender->notify(new StatusNew($transaction));
            if ($senderStoreUsers = $transaction->sender->storeUsers) {
                foreach ($senderStoreUsers as $senderStoreUser) {
                    $senderStoreUser->notify(new StatusNew($transaction));
                }
            }
        }
        if ($transaction->status == Transactions::$statusSent && $transaction->status <> $this->original['status']) {
            // send email transaction status sent to receiver
            $transaction->receiver->notify(new StatusSent($transaction));
        }
        if ($transaction->status == Transactions::$statusReceived && $transaction->status <> $this->original['status']) {
            // send email transaction status received to receiver
        }
    }

    public function saved(Transactions $transaction)
    {

    }
}
