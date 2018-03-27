<?php

namespace Modules\UserAddresses\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Models\Users;
use Illuminate\Http\Request;
use Modules\UserAddresses\Models\UserAddresses;
// use Modules\Users\Models\Users;

class UserAddressesController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['user'] = Users::findOrFail($request->query('user_id'));
        $data['userAddress'] = new UserAddresses;
        return view('useraddresses::backend/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\UserAddresses\Http\Requests\Backend\StoreRequest $request)
    {
        $userAddress = new UserAddresses;
        $userAddress->fill($request->input())->save();
        $request->input('primary') ? $userAddress->primaryUpdate($userAddress->id) : '';
        flash(trans('cms.data_has_been_created'))->success()->important();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['user'] = Users::findOrFail($request->query('user_id'));
        $data['userAddress'] = UserAddresses::findOrFail($id);
        return view('useraddresses::backend/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\UserAddresses\Http\Requests\Backend\UpdateRequest $request, $id)
    {
        $userAddress = UserAddresses::findOrFail($id);
        $userAddress->fill($request->input())->save();
        $request->input('primary') ? $userAddress->primaryUpdate($userAddress->id) : '';
        flash(trans('cms.data_has_been_updated'))->success()->important();
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
        $userAddress = UserAddresses::findOrFail($id);
        $userAddress->delete();
        flash(trans('cms.data_has_been_deleted'))->success()->important();
        return redirect()->route('backend.users.edit', [$userAddress->user_id, '#user_addresses']);
    }
}
