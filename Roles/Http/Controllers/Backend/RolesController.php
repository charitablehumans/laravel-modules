<?php

namespace Modules\Roles\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Permissions\Models\Permission;
use Modules\Roles\Models\Role;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $request->query('sort') ?: $request->query->set('sort', 'name:asc');
        $request->query('limit') ?: $request->query->set('limit', 10);

        $data['roles'] = Role::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { (new Role)->action($request->query()); return redirect()->back(); }

        return view('roles::backend/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['permissions'] = Permission::orderBy('name')->get();
        $data['role'] = new Role;
        return view('roles::backend/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\Roles\Http\Requests\Backend\StoreRequest $request)
    {
        $role = new Role;
        $role->fill($request->input())->save();
        $role->syncPermissions($request->input('permissions'));
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
        $data['permissions'] = Permission::orderBy('name')->get();
        $data['role'] = Role::findOrFail($id);
        return view('roles::backend/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\Roles\Http\Requests\Backend\UpdateRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->fill($request->input())->save();
        $role->syncPermissions($request->input('permissions'));
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
        $role = Role::findOrFail($id);
        $role->syncPermissions()->delete($id);
        flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }
}
