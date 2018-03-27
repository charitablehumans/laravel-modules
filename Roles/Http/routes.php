<?php

Route::group(['middleware' => 'web', 'prefix' => 'roles', 'namespace' => 'Modules\Roles\Http\Controllers'], function()
{
    Route::get('/', 'RolesController@index');
});
