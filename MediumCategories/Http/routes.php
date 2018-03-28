<?php

Route::group(['middleware' => 'web', 'prefix' => 'mediumcategories', 'namespace' => 'Modules\MediumCategories\Http\Controllers'], function()
{
    Route::get('/', 'MediumCategoriesController@index');
});
