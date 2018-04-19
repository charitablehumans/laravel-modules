<?php

namespace Modules\DokuMyshortcart\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DokuMyshortcart\Models\DokuMyshortcartTransactionLogs;
use Modules\DokuMyshortcart\Models\DokuMyshortcartTransactions;
use Modules\Transactions\Models\Transactions;

class DokuMyshortcartController extends Controller
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

        // 2. Insert into doku_myshortcart_transactions
        $dokuMyshortcartTransaction = DokuMyshortcartTransactions::firstOrCreate(['STOREID' => $dokuMyshortcartTransactionTransform->STOREID, 'TRANSIDMERCHANT' => $dokuMyshortcartTransactionTransform->TRANSIDMERCHANT]);
        $dokuMyshortcartTransaction->fill($dokuMyshortcartTransactionTransform->getAttributes())->save();

        // 3. Insert into doku_myshortcart_transaction_logs
        //

        $data['doku_myshortcart_transaction'] = $dokuMyshortcartTransaction;
        $data['transaction'] = Transactions::findOrFail($request->input('id'));
        return view('dokumyshortcart::backend/doku_myshortcart/store', $data);
    }

    /**
     * STOREID : 10239584
     * AMOUNT : 1160000
     * TRANSIDMERCHANT : 2
     * WORDS : 890d8c2d9ac349b99367c3698ad70cf9e62db7df
     */
    public function verifyStore(Request $request)
    {
        // 1. Insert into doku_myshortcart_transaction_logs
        $log = $request->input();
        $log['type'] = 'verify';
        (new DokuMyshortcartTransactionLogs)->createLog($log);

        // 2.1 If doku_myshortcart_transactions is found
        if ($dokuMyshortcartTransaction = DokuMyshortcartTransactions
            ::where('TRANSIDMERCHANT', $request->input('TRANSIDMERCHANT'))
            ->where('AMOUNT', $request->input('AMOUNT'))
            ->first()
        ) {
            $transaction = $dokuMyshortcartTransaction->transaction;
            $transaction->payment = 'doku';
            $transaction->save();

            return 'Continue';
        }

        // 3. If doku_myshortcart_transactions not found
        return 'Stop';
    }

    /**
     * TRANSIDMERCHANT=2
     * &AMOUNT=1160000
     * &RESULT=Success
     * &PTYPE=CREDIT CARD
     */
    public function notifyStore(Request $request)
    {
        // 1. Insert into doku_myshortcart_transaction_logs
        $log = $request->input();
        $log['type'] = 'notify';
        (new DokuMyshortcartTransactionLogs)->createLog($log);

        // 2.1 If doku_myshortcart_transactions is found
        if ($dokuMyshortcartTransaction = DokuMyshortcartTransactions
            ::where('TRANSIDMERCHANT', $request->input('TRANSIDMERCHANT'))
            ->first()
        ) {
            // 2.2 If payment success
            if ($request->input('RESULT') == 'Success') {
                $transaction = $dokuMyshortcartTransaction->transaction;
                $transaction->status = 'new';
                $transaction->payment_date = date('Y-m-d H:i:s');
                $transaction->payment_status = 1;
                $transaction->payment_type = $request->input('PTYPE');
                $transaction->save();

                return 'Continue';
            }
        }

        // 3. If doku_myshortcart_transactions not found
        return 'Stop';
    }

    /**
     * TRANSIDMERCHANT=2
     * &TRANSDATE=2018-04-12 11:06:56
     * &PTYPE=CREDIT CARD
     * &AMOUNT=1160000
     * &RESULT=SUCCESS
     * &STATUSCODE=00
     * &EXTRAINFO=
     */
    public function redirectStore(Request $request)
    {
        // 1. Insert into doku_myshortcart_transaction_logs
        $log = $request->input();
        $log['type'] = 'redirect';
        (new DokuMyshortcartTransactionLogs)->createLog($log);

        // 2.1 If doku_myshortcart_transactions is found
        if ($dokuMyshortcartTransaction = DokuMyshortcartTransactions
            ::where('TRANSIDMERCHANT', $request->input('TRANSIDMERCHANT'))
            ->first()
        ) {
            $data['id'] = $dokuMyshortcartTransaction->transaction->id;

            if (in_array($request->input('PTYPE'), ['CREDIT CARD'])) {
                // 2.2 If PTYPE in Creditcard, then redirect to redirect_route
                return redirect()->route(\Config::get('dokumyshortcart.redirect_route'), $data);
            } else {
                // 2.3 redirect to payment_confirmation_route
                return redirect()->route(\Config::get('dokumyshortcart.payment_confirmation_route'), $data);
            }
        }
    }

    public function cancel(Request $request)
    {
        // 1. Insert into doku_myshortcart_transaction_logs
        $log = $request->input();
        $log['type'] = 'cancel';
        (new DokuMyshortcartTransactionLogs)->createLog($log);

        return redirect()->route(\Config::get('dokumyshortcart.cancel_route'));
    }
}
