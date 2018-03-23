<?php

Route::group(['middleware' => 'web', 'prefix' => 'permissions', 'namespace' => 'Modules\Permissions\Http\Controllers'], function()
{
    Route::get('/', 'PermissionsController@index');
});
