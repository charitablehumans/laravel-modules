<?php

Route::group(['middleware' => 'web', 'prefix' => 'termtranslations', 'namespace' => 'Modules\TermTranslations\Http\Controllers'], function()
{
    Route::get('/', 'TermTranslationsController@index');
});
