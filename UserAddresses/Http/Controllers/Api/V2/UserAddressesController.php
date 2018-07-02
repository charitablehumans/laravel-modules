<?php

namespace Modules\UserAddresses\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserAddresses\Models\UserAddresses;

class UserAddressesController extends Controller
{
    public function store(\Modules\UserAddresses\Http\Requests\Api\V2\UserAddresses\StoreRequest $request)
    {
        $userAddress = new UserAddresses;
        $userAddress->user_id = \Auth::user()->id;
        $userAddress->fill($request->input())->save();

        if ($request->input('primary')) {
            $userAddress = $userAddress->primaryUpdate($userAddress->id);
        }

        return new \Modules\UserAddresses\Http\Resources\Api\UserAddressResource($userAddress);
    }

    public function update(\Modules\UserAddresses\Http\Requests\Api\V2\UserAddresses\UpdateRequest $request, $id)
    {
        $userAddress = UserAddresses::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        $userAddress->fill($request->input())->save();
        return new \Modules\UserAddresses\Http\Resources\Api\UserAddressResource($userAddress);
    }
}
