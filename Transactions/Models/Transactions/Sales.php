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
        parent::reject($id);

        $transaction = self::with(['transactionDetails', 'transactionDetails.product', 'transactionDetails.product.postProduct'])->findOrFail($id);
        $transaction->status = 'returned';
        $transaction->save();

        if ($transaction->transactionDetails) {
            foreach ($transaction->transactionDetails as $transactionDetail) {
                $transactionDetail->product->postProduct->stock += $transactionDetail->quantity;
                $transactionDetail->product->postProduct->save();
            }
        }
    }
}
