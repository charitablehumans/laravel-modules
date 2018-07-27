<?php

namespace Modules\Rajaongkir\Http\Controllers\Api\V1\Rajaongkir\Cost;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Rajaongkir\Models\Rajaongkir;

class CourierController extends Controller
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
    public function store(\Modules\Rajaongkir\Http\Requests\Api\V1\Rajaongkir\Cost\Courier\StoreRequest $request)
    {
        $rajaongkir = new Rajaongkir;
        $cost = $rajaongkir->getCostCourier($request->input());
        return response()->json($cost);
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
}
