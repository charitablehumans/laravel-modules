<?php

namespace Modules\Geocodes\Http\Controllers\Api\Geocodes;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Geocodes\Models\Geocodes\Provinces;

class ProvincesController extends Controller
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
    public function index(Request $request)
    {
        $provinces = Provinces::search($request->query())->orderBy('name');
        $provinces = $request->query('per_page') ? $provinces->paginate((int) $request->query('per_page')) : $provinces->get();
        return \Modules\Geocodes\Transformers\Api\GeocodeResource::collection($provinces);
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
        return new \Modules\UserAddresses\Http\Resources\Api\UserAddress($userAddress);
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
