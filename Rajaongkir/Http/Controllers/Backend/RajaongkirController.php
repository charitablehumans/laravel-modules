<?php

namespace Modules\Rajaongkir\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Rajaongkir\Models\Rajaongkir;

class RajaongkirController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $rajaongkir = new Rajaongkir;

        $provinces = $rajaongkir->getProvinces();
        dump($provinces);

        $province = $rajaongkir->getProvinces(['id' => 1]);
        dump($province);

        $cities = $rajaongkir->getCities();
        dump($cities);

        $cities = $rajaongkir->getCities(['province' => 21]);
        dump($cities);

        $city = $rajaongkir->getCities(['id' => 1]);
        dump($city);

        return view('rajaongkir::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('rajaongkir::create');
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
    public function show()
    {
        return view('rajaongkir::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('rajaongkir::edit');
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
