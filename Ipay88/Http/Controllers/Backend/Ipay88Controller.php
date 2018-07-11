<?php

namespace Modules\Ipay88\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ipay88\Models\Ipay88Transactions;
use Modules\Transactions\Models\Transactions;

class Ipay88Controller extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['ipay88Transactions'] = new Ipay88Transactions;
        $data['transactions'] = Transactions::orderBy('id')->get();
        return view('ipay88::backend/ipay88/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\Ipay88\Http\Requests\Backend\Ipay88\StoreRequest $request)
    {
        // 1. Transform to be parameter ipay88
        $ipay88TransactionTransform = (new Ipay88Transactions)->transform($request->input('id'), $request->input());

        // 2. Insert into ipay88_transactions
        $ipay88Transaction = new Ipay88Transactions;
        $ipay88Transaction->fill($ipay88TransactionTransform->getAttributes())->save();

        $data['ipay88Transaction'] = $ipay88Transaction;
        $data['transaction'] = Transactions::findOrFail($request->input('id'));
        return view('ipay88::backend/ipay88/store', $data);
    }
}
