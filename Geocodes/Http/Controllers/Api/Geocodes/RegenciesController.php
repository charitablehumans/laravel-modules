<?php

namespace Modules\Geocodes\Http\Controllers\Api\Geocodes;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Geocodes\Models\Geocodes\Regencies;

class RegenciesController extends Controller
{
    public function index(Request $request)
    {
        $regencies = Regencies::search($request->query())->orderBy('name');
        $regencies = $request->query('per_page') ? $regencies->paginate((int) $request->query('per_page')) : $regencies->get();
        return \Modules\Geocodes\Transformers\Api\GeocodeResource::collection($regencies);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
