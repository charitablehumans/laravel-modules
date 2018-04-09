<?php

namespace Modules\UserAddresses\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserAddresses\Models\UserAddresses;

class UserAddressesController extends Controller
{
    /**
     * @SWG\Get(
     *      path="/api/user-addresses",
     *      summary="",
     *      description="
     *          {
     *              'data': [
     *                  {
     *                      'id': 11,
     *                      'user_id': 13,
     *                      'name': 'Member Address 1',
     *                      'phone_number': '087877118199',
     *                      'province_id': 1,
     *                      'regency_id': 2,
     *                      'district_id': 3,
     *                      'postal_code': '14450',
     *                      'address': 'Jl. Jelambar Aladin',
     *                      'primary': 1,
     *                      'created_at': {
     *                          'date': '2018-03-27 04:00:15.000000',
     *                          'timezone_type': 3,
     *                          'timezone': 'UTC'
     *                      },
     *                      'updated_at': {
     *                          'date': '2018-03-27 04:01:45.000000',
     *                          'timezone_type': 3,
     *                          'timezone': 'UTC'
     *                      }
     *                  },
     *                  ...
     *              ],
     *              'links': {
     *                  'first': 'http:://chicknroll.id/api/user-addresses?page=1',
     *                  'last': 'http:://chicknroll.id/api/user-addresses?page=1',
     *                  'prev': null,
     *                  'next': null
     *              },
     *              'meta': {
     *                  'current_page': 1,
     *                  'from': 1,
     *                  'last_page': 1,
     *                  'path': 'http:://chicknroll.id/api/user-addresses',
     *                  'per_page': 15,
     *                  'to': 1,
     *                  'total': 1
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"user_addresses"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index()
    {
        $userAddresses = UserAddresses::where('user_id', \Auth::user()->id)->orderBy('primary', 'desc')->latest()->paginate();
        return \Modules\UserAddresses\Transformers\Api\UserAddressResource::collection($userAddresses);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('useraddresses::create');
    }

    /**
     * @SWG\Post(
     *      path="/api/user-addresses",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'id': 13,
     *                  'user_id': 13,
     *                  'name': 'Member Address 1',
     *                  'phone_number': '087877118199',
     *                  'province_id': '1',
     *                  'regency_id': '2',
     *                  'district_id': '3',
     *                  'postal_code': '14450',
     *                  'address': 'Jl. Jelambar Aladin',
     *                  'primary': 0,
     *                  'created_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"user_addresses"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Parameter(name="name", type="string", in="formData", required=true, description="varchar(191)"),
     *      @SWG\Parameter(name="phone_number", type="string", in="formData", required=true, description="varchar(20)"),
     *      @SWG\Parameter(name="province_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="regency_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="district_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="postal_code", type="string", in="formData", required=true, description="varchar(10)"),
     *      @SWG\Parameter(name="address", type="string", in="formData", required=true, description="text"),
     *      @SWG\Parameter(name="primary", type="string", in="formData", required=false, description="enum(\'0\', \'1\')"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(\Modules\UserAddresses\Http\Requests\Api\StoreRequest $request)
    {
        $userAddress = new UserAddresses;
        $userAddress->user_id = \Auth::user()->id;
        $userAddress->fill($request->input())->save();

        if ($request->input('primary')) {
            $userAddress = $userAddress->primaryUpdate($userAddress->id);
        }

        return new \Modules\UserAddresses\Transformers\Api\UserAddressResource($userAddress);
    }

    /**
     * @SWG\Get(
     *      path="/api/user-addresses/{id}",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'id': 13,
     *                  'user_id': 13,
     *                  'name': 'Member Address 1',
     *                  'phone_number': '087877118199',
     *                  'province_id': '1',
     *                  'regency_id': '2',
     *                  'district_id': '3',
     *                  'postal_code': '14450',
     *                  'address': 'Jl. Jelambar Aladin',
     *                  'primary': 0,
     *                  'created_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"user_addresses"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Parameter(name="id", type="integer", in="path", required=true, description="biginteger(20)"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=404, description="Not Found"),
     * )
     */
    public function show($id)
    {
        $userAddress = UserAddresses::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        return new \Modules\UserAddresses\Transformers\Api\UserAddressResource($userAddress);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('useraddresses::edit');
    }

    /**
     * @SWG\Put(
     *      path="/api/user-addresses/{id}",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'id': 13,
     *                  'user_id': 13,
     *                  'name': 'Member Address 1',
     *                  'phone_number': '087877118199',
     *                  'province_id': '1',
     *                  'regency_id': '2',
     *                  'district_id': '3',
     *                  'postal_code': '14450',
     *                  'address': 'Jl. Jelambar Aladin',
     *                  'primary': 0,
     *                  'created_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"user_addresses"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Parameter(name="id", type="integer", in="path", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="name", type="string", in="formData", required=true, description="varchar(191)"),
     *      @SWG\Parameter(name="phone_number", type="string", in="formData", required=true, description="varchar(20)"),
     *      @SWG\Parameter(name="province_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="regency_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="district_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="postal_code", type="string", in="formData", required=true, description="varchar(10)"),
     *      @SWG\Parameter(name="address", type="string", in="formData", required=true, description="text"),
     *      @SWG\Parameter(name="primary", type="string", in="formData", required=false, description="enum(\'0\', \'1\')"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=404, description="Not Found"),
     *      @SWG\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(\Modules\UserAddresses\Http\Requests\Api\UpdateRequest $request, $id)
    {
        $userAddress = UserAddresses::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        $userAddress->fill($request->input())->save();
        return new \Modules\UserAddresses\Transformers\Api\UserAddressResource($userAddress);
    }

    /**
     * @SWG\Delete(
     *      path="/api/user-addresses/{id}",
     *      summary="",
     *      description="",
     *      produces={"application/json"},
     *      tags={"user_addresses"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Parameter(name="id", type="integer", in="path", required=true, description="biginteger(20)"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=404, description="Not Found"),
     * )
     */
    public function destroy($id)
    {
        $userAddress = UserAddresses::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        $userAddress->delete();
        return response()->json();
    }

    /**
     * @SWG\Put(
     *      path="/api/user-addresses/{id}/primary",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'id': 13,
     *                  'user_id': 13,
     *                  'name': 'Member Address 1',
     *                  'phone_number': '087877118199',
     *                  'province_id': '1',
     *                  'regency_id': '2',
     *                  'district_id': '3',
     *                  'postal_code': '14450',
     *                  'address': 'Jl. Jelambar Aladin',
     *                  'primary': 1,
     *                  'created_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-27 04:01:25.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"user_addresses"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Parameter(name="id", type="integer", in="path", required=true, description="biginteger(20)"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=404, description="Not Found"),
     * )
     */
    public function primaryUpdate(Request $request, $id)
    {
        $userAddress = UserAddresses::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        $userAddress = $userAddress->primaryUpdate($userAddress->id);
        return new \Modules\UserAddresses\Transformers\Api\UserAddressResource($userAddress);
    }
}
