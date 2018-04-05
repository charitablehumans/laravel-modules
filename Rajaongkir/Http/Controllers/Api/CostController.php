<?php

namespace Modules\Rajaongkir\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Rajaongkir\Models\Rajaongkir;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
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
    public function store(\Modules\Rajaongkir\Http\Requests\Api\Cost\StoreRequest $request)
    {
        $rajaongkir = new Rajaongkir;
        $costs = $rajaongkir->getCosts($request->input(), $rajaongkir->getCouriersId());
        return response()->json($costs);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
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

    public function courierStore(\Modules\Rajaongkir\Http\Requests\Api\Cost\CourierStoreRequest $request)
    {
        $rajaongkir = new Rajaongkir;
        $cost = $rajaongkir->getCostCourier($request->input());
        return response()->json($cost);
    }
}
