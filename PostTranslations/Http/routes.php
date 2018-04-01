<?php

Route::group(['middleware' => 'web', 'prefix' => 'posttranslations', 'namespace' => 'Modules\PostTranslations\Http\Controllers'], function()
{
    Route::get('/', 'PostTranslationsController@index');
});
