<?php

namespace Modules\Permissions\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Permissions\Models\Permission;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        $request->query('sort') ?: $request->query->set('sort', 'name:asc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['permissions'] = Permission::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { (new Permission)->action($request->query()); return redirect()->back(); }

        return view('permissions::backend/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['permission'] = new Permission;
        return view('permissions::backend/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\Permissions\Http\Requests\Backend\StoreRequest $request)
    {
        Permission::create($request->input());
        flash(trans('cms::cms.data_has_been_created'))->success()->important();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['permission'] = Permission::search(['id' => $id])->firstOrFail();
        return view('permissions::backend/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\Permissions\Http\Requests\Backend\UpdateRequest $request, $id)
    {
        $permission = Permission::search(['id' => $id])->firstOrFail();
        $permission->fill($request->input())->save();
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $permission = Permission::search(['id' => $id])->firstOrFail();
        $permission->delete();
        flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }
}
