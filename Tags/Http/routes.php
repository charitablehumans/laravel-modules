<?php

Route::group(['middleware' => 'web', 'prefix' => 'tags', 'namespace' => 'Modules\Tags\Http\Controllers'], function()
{
    Route::get('/', 'TagsController@index');
});
