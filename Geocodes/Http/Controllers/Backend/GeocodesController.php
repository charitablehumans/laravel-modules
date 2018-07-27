<?php

namespace Modules\Geocodes\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Geocodes\Models\Geocodes;

class GeocodesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $request->query('sort') ?: $request->query->set('sort', 'updated_at:desc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['model'] = new Geocodes;
        $data['geocodes'] = Geocodes::with('parent')->search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { (new Geocodes)->action($request->query()); return redirect()->back(); }

        return view('geocodes::backend/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['geocode'] = new Geocodes;
        return view('geocodes::backend/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\Geocodes\Http\Requests\Backend\StoreRequest $request)
    {
        $geocode = new Geocodes;
        $geocode->fill($request->input())->save();
        flash(trans('cms::cms.data_has_been_created'))->success()->important();
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('geocodes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['geocode'] = Geocodes::findOrFail($id);
        return view('geocodes::backend/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(\Modules\Geocodes\Http\Requests\Backend\UpdateRequest $request, $id)
    {
        $geocode = Geocodes::findOrFail($id);
        $geocode->fill($request->input())->save();
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function delete($id)
    {
        $geocode = Geocodes::findOrFail($id);
        $geocode->delete($id);
        flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }

    public function sync()
    {
        $geocode = new Geocodes;
        $count = $geocode->sync();
        flash(trans('cms::cms.data_has_been_updated').' ('.$count.')')->success()->important();
        return redirect()->back();
    }
}
