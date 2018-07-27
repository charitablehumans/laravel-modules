<?php

namespace Modules\Rajaongkir\Http\Controllers\Backend;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Rajaongkir\Models\Rajaongkir;

class RajaongkirController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Rajaongkir;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $provinces = $this->model->getProvinces();
        dump($provinces);

        $province = $this->model->getProvinces(['id' => 1]);
        dump($province);

        $cities = $this->model->getCities();
        dump($cities);

        $cities = $this->model->getCities(['province' => 21]);
        dump($cities);

        $city = $this->model->getCities(['id' => 1]);
        dump($city);

        $subdistricts = $this->model->getSubdistricts(['city' => 155]);
        dump($subdistricts);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
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
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
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

    public function tracking($courier, $waybill, Request $request)
    {
        $data['waybill'] = $this->model->getWaybill($request->route()->parameters());
        return view('rajaongkir::backend/rajaongkir/tracking', $data);
    }
}
