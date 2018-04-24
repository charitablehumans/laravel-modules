<?php

namespace Modules\Options\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\Options\Models\Options;

class OptionsController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->query('sort') ?: $request->query->set('sort', 'name:asc');
        $request->query('limit') ?: $request->query->set('limit', 10);

        $data['options'] = Options::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { (new Options)->action($request->query()); return redirect()->back(); }

        return view('options::backend/options/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['option'] = new Options;
        return view('options::backend/options/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\Options\Http\Requests\Backend\Options\StoreRequest $request)
    {
        Options::create($request->input());
        flash(trans('cms.data_has_been_created'))->success()->important();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['option'] = Options::findOrFail($id);
        return view('options::backend/options/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\Options\Http\Requests\Backend\Options\UpdateRequest $request, $id)
    {
        $option = Options::findOrFail($id);
        $option->fill($request->input())->save();
        flash(trans('cms.data_has_been_updated'))->success()->important();
        return redirect()->back();
    }

    public function delete($id)
    {
        $option = Options::findOrFail($id);
        $option->delete();
        flash(trans('cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }
}
