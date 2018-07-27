<?php

Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['authApi']], function () {
        Route::group(['middleware' => ['permission:api rajaongkir']], function () {
            Route::post('api/rajaongkir/cost', ['as' => 'api.rajaongkir.cost.store', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Api\CostController@store']);
            Route::post('api/rajaongkir/cost/courier', ['as' => 'api.rajaongkir.cost.courierStore', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Api\CostController@courierStore']);
            Route::get('api/rajaongkir/couriers', ['as' => 'api.rajaongkir.couriers.index', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Api\CouriersController@index']);
        });
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend rajaongkir']], function () {
            Route::resource('backend/rajaongkir', '\Modules\Rajaongkir\Http\Controllers\Backend\RajaongkirController', ['as' => 'backend'])->only(['index']);
            Route::get('backend/rajaongkir/tracking/{courier}/{waybill}', ['as' => 'backend.rajaongkir.tracking', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Backend\RajaongkirController@tracking']);
        });
    });
});
