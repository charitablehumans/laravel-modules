<?php

namespace Modules\Transactions\Models\Transactions;

use Illuminate\Database\Eloquent\Builder;

class Sales extends \Modules\Transactions\Models\Transactions
{
    protected $attributes = [
        'type' => 'sales',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'sales'); });
    }

    public function reject($id)
    {
        // 1. Update transaction set status = 'returned'
        $transaction = self::where('id', $id)->whereIn('status', ['new', 'processed', 'sent'])->firstOrFail();
        $transaction->status = 'returned';
        $transaction->save();

        // 2. Foreach transaction details, then return to stock
        if ($transaction->transactionDetails) {
            foreach ($transaction->transactionDetails as $transactionDetail) {
                $transactionDetail->product->postProduct->stock += $transactionDetail->quantity;
                $transactionDetail->product->postProduct->save();
            }
        }

        // 3. Return grand total to user balance
        $user = \Modules\Users\Models\Users::findOrFail($transaction->receiver_id);
        $user->balance += $transaction->grand_total;
        $user->save();
    }
}
