<?php

Route::group(['middleware' => 'web'], function()
{
    Route::get('frontend/rpx/sales/tracking/{awb}', ['as' => 'frontend.rpx.sales.tracking.show', 'uses' => '\Modules\Rpx\Http\Controllers\Frontend\Rpx\TrackingController@show']);
});
