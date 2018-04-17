<?php

namespace Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcart\Transactions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DokuMyshortcart\Models\DokuMyshortcartTransactions;
use Modules\Transactions\Models\Transactions;

class PurchasesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\DokuMyshortcart\Http\Requests\Api\DokuMyshortcart\StoreRequest $request)
    {
        // 1. Transform to be parameter doku
        $dokuMyshortcartTransactionTransform = (new DokuMyshortcartTransactions)->transform($request->input('id'), $request->input());
        $transaction = Transactions::search(['id' => $request->input('id'), 'purchase_ownership' => true])->firstOrFail();
        return response()->json(new \Modules\Transactions\Http\Resources\Api\TransactionResource($transaction));
    }
}
