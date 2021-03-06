<?php

namespace Modules\DokuMyshortcart\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DokuMyshortcart\Models\DokuMyshortcartTransactions;
use Modules\Transactions\Models\Transactions;

class DokuMyshortcartController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['doku_myshortcart_transaction'] = new DokuMyshortcartTransactions;
        $data['transactions'] = Transactions::orderBy('id')->get();
        return view('dokumyshortcart::backend/doku_myshortcart/create', $data);
    }

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

        $data['doku_myshortcart_transaction'] = $dokuMyshortcartTransaction;
        $data['transaction'] = Transactions::findOrFail($request->input('id'));
        return view('dokumyshortcart::backend/doku_myshortcart/store', $data);
    }
}
