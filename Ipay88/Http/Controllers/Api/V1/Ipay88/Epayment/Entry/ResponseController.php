<?php

namespace Modules\Ipay88\Http\Controllers\Api\V1\Ipay88\Epayment\Entry;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ipay88\Models\Ipay88TransactionLogs;
use Modules\Ipay88\Models\Ipay88Transactions;
use Modules\Transactions\Models\Transactions;

class ResponseController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Ipay88TransactionLogs;
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // 1. Insert into ipay88_transaction_logs
        $log = $request->input();
        $log['type'] = route('ipay88.api.v1.ipay88.epayment.entry.response.store');
        $ipay88TransactionLog = $this->model->createLog($log);

        // 2. If ipay88_transactions is found
        if ($ipay88Transaction = Ipay88Transactions
            ::where('RefNo', $request->input('RefNo'))
            ->first()
        ) {
            $transaction = $ipay88Transaction->transaction;
            if ($request->input('Status') == Ipay88TransactionLogs::$statusSuccess) {
                $transaction->status = Transactions::$statusNew;
            }
            $transaction->payment = \Module::find('ipay88')->getName();
            $transaction->payment_status = $ipay88Transaction->getTransactionPaymentStatusOptions()[$request->input('Status')];
            $transaction->payment_type = $ipay88Transaction->getPaymentMethodIdNameOptions()[$request->input('PaymentId')];
            $transaction->save();

            // 2.1 Show message, view based on status
            $messages = [
                $ipay88TransactionLog->getStatusIdNameOptions()[$request->input('Status')],
                $ipay88TransactionLog->ErrDesc,
            ];
            flash(implode('. ', $messages).'.')->overlay()->important();
            return view('ipay88::frontend/ipay88/epayment/entry/store/status/'.$request->input('Status'), $ipay88TransactionLog->getAttributes());
        }
    }
}
