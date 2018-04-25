<?php

Route::group(['middleware' => 'web'], function()
{
    Route::get('locale/{locale?}', ['as' => 'locale.localeUpdate', 'uses' => '\Modules\Cms\Http\Controllers\Frontend\LocaleController@localeUpdate']);
    Route::get('', ['as' => 'frontend', 'uses' => '\Modules\Cms\Http\Controllers\FrontendController@index']);
});
