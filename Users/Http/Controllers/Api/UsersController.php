<?php

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Resources\UserResource;
use Modules\Users\Models\Users;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    /**
     * @SWG\Get(
     *      path="/api/users/profile",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'id': 13,
     *                  'name': 'Jovi',
     *                  'email': 'jovi@mailinator.com',
     *                  'phone_number': '087877118199',
     *                  'access_token': '$2y$10$YqOZ/5F8YeV9.CXJZwrO8elPIZdAezbaxrBqzv8TfYoSbnp996hw2',
     *                  'verified': 1,
     *                  'verification_code': '863086',
     *                  'date_of_birth': '0000-00-00',
     *                  'address': '',
     *                  'balance': 499916,
     *                  'game_token': 1000000,
     *                  'created_at': {
     *                      'date': '2018-03-15 03:33:42.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-15 03:34:05.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"users"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     * )
     */
    public function profile()
    {
        $user = \Auth::user();
        return new UserResource($user);
    }

    /**
     * @SWG\Put(
     *      path="/api/users/profile",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'id': 13,
     *                  'name': 'Jovi',
     *                  'email': 'jovi@mailinator.com',
     *                  'phone_number': '087877118199',
     *                  'access_token': '$2y$10$YqOZ/5F8YeV9.CXJZwrO8elPIZdAezbaxrBqzv8TfYoSbnp996hw2',
     *                  'verified': 1,
     *                  'verification_code': '863086',
     *                  'date_of_birth': '0000-00-00',
     *                  'address': '',
     *                  'balance': 499916,
     *                  'game_token': 1000000,
     *                  'created_at': {
     *                      'date': '2018-03-15 03:33:42.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-15 03:34:05.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"users"},
     *      security={
     *          { "Access-Token": {} }
     *      },
     *      @SWG\Parameter(name="name", type="string", in="formData", required=true, description="varchar(191)"),
     *      @SWG\Parameter(name="email", type="string", in="formData", required=true, description="varchar(191)"),
     *      @SWG\Parameter(name="phone_number", type="string", in="formData", required=true, description="varchar(20)"),
     *      @SWG\Parameter(name="password", type="string", in="formData", required=false, description="varchar(191)"),
     *      @SWG\Parameter(name="date_of_birth", type="string", in="formData", required=true, description="date"),
     *      @SWG\Parameter(name="address", type="string", in="formData", required=true, description=""),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function profileUpdate(\Modules\Users\Http\Requests\Api\ProfileUpdateRequest $request)
    {
        $request->input('password') ? $request->merge(['password' => \Hash::make($request->input('password'))]) : $request->request->remove('password');
        $user = \Auth::user();
        $user->fill($request->input())->save();
        return new UserResource($user);
    }
}
