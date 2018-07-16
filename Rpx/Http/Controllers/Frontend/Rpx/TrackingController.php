<?php

namespace Modules\Rpx\Http\Controllers\Frontend\Rpx;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

//use Modules\Rpx\Models\RpxSoap;

class TrackingController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new \Modules\Rpx\Models\RpxSoap;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('rpx::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('rpx::create');
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
    public function show($awb)
    {
        // get tracking awb from rpx soap model
        $getTrackingAWB = $this->model->getTrackingAWB($awb);

        // check the data is avaliable or not
        $check_getTrackingAWB = array_key_exists('DATA', $getTrackingAWB['RPX']);

        if($check_getTrackingAWB == true) {

            $data['has_record'] = true;

            $data['details'] = $getTrackingAWB['RPX'];

            $data['activities'] = $getTrackingAWB['RPX']['DATA'];

            $data['awb_number'] = $awb;

            return view('rpx::show', $data);

        } else {

            $data['has_record'] = false;

            return view('rpx::show', $data);

        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('rpx::edit');
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
