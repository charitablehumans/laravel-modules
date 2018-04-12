<?php

namespace Modules\Doku\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doku\Models\DokuTransactions;
use Modules\Transactions\Models\Transactions;

class DokuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('doku::backend/index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['transactions'] = Transactions::orderBy('id')->get();
        return view('doku::backend/create', $data);
    }

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
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('doku::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('doku::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
