<?php

namespace Modules\Transactions\Http\Controllers\Api\Transactions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transactions\Http\Resources\Api\TransactionResource;
use Modules\Transactions\Models\Transactions\Sales;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $purchases = Sales::search(['purchase_ownership' => true, 'sort' => 'updated_at:desc'])->paginate();
        return response()->json(TransactionResource::collection($purchases));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $purchase = Sales::search(['purchase_ownership' => true, 'sort' => 'updated_at:desc'])->firstOrFail();
        return response()->json(new TransactionResource($purchase));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        //
    }

    public function reject($id)
    {
        $purchase = (new Sales)->reject($id);
        return response()->json(new TransactionResource($purchase));
    }
}
