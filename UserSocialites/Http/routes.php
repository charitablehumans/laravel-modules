<?php

Route::group(['middleware' => 'web', 'prefix' => 'usersocialites', 'namespace' => 'Modules\UserSocialites\Http\Controllers'], function()
{
    Route::get('/', 'UserSocialitesController@index');
});
