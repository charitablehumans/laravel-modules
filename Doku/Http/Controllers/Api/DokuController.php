<?php

namespace Modules\Doku\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doku\Models\DokuTransactionLogs;
use Modules\Doku\Models\DokuTransactions;
use Modules\Transactions\Models\Transactions;

class DokuController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\Doku\Http\Requests\Backend\StoreRequest $request)
    {
        // 1. Transform to be parameter doku
        $dokuTransactionTransform = (new DokuTransactions)->transform($request->input('id'));

        // 2. Insert into doku_transactions
        $dokuTransaction = DokuTransactions::firstOrCreate(['STOREID' => $dokuTransactionTransform->STOREID, 'TRANSIDMERCHANT' => $dokuTransactionTransform->TRANSIDMERCHANT]);
        $dokuTransaction->fill($dokuTransactionTransform->getAttributes())->save();

        // 3. Insert into doku_transaction_logs
        //

        $data['dokuTransaction'] = $dokuTransaction;
        $data['transaction'] = Transactions::findOrFail($request->input('id'));
        return view('doku::backend/store', $data);
    }

    /**
     * STOREID : 10239584
     * AMOUNT : 1160000
     * TRANSIDMERCHANT : 2
     * WORDS : 890d8c2d9ac349b99367c3698ad70cf9e62db7df
     */
    public function verifyStore(Request $request)
    {
        // 1. Insert into doku_transaction_logs
        $log = $request->input();
        $log['type'] = 'verify';
        (new DokuTransactionLogs)->createLog($log);

        // 2.1 If doku_transactions is found
        if ($dokuTransaction = DokuTransactions
            ::where('TRANSIDMERCHANT', $request->input('TRANSIDMERCHANT'))
            ->where('AMOUNT', $request->input('AMOUNT'))
            ->first()
        ) {
            $transaction = $dokuTransaction->transaction;
            $transaction->payment = 'doku';
            $transaction->save();

            return 'Continue';
        }

        // 3. If doku_transactions not found
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
        // 1. Insert into doku_transaction_logs
        $log = $request->input();
        $log['type'] = 'notify';
        (new DokuTransactionLogs)->createLog($log);

        // 2.1 If doku_transactions is found
        if ($dokuTransaction = DokuTransactions
            ::where('TRANSIDMERCHANT', $request->input('TRANSIDMERCHANT'))
            ->first()
        ) {
            // 2.2 If payment success
            if ($request->input('RESULT') == 'Success') {
                $transaction = $dokuTransaction->transaction;
                $transaction->payment_date = date('Y-m-d H:i:s');
                $transaction->payment_status = 1;
                $transaction->payment_type = $request->input('PTYPE');
                $transaction->save();

                return 'Continue';
            }
        }

        // 3. If doku_transactions not found
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
        // 1. Insert into doku_transaction_logs
        $log = $request->input();
        $log['type'] = 'redirect';
        (new DokuTransactionLogs)->createLog($log);

        // 2.1 If doku_transactions is found
        if ($dokuTransaction = DokuTransactions
            ::where('TRANSIDMERCHANT', $request->input('TRANSIDMERCHANT'))
            ->first()
        ) {
            $data['id'] = $dokuTransaction->transaction->id;
            return redirect()->route(\Config::get('doku.redirect_route'), $data);
        }
    }

    public function cancel(Request $request)
    {
        // 1. Insert into doku_transaction_logs
        $log = $request->input();
        $log['type'] = 'cancel';
        (new DokuTransactionLogs)->createLog($log);

        return redirect()->route(\Config::get('doku.cancel_route'));
    }
}
