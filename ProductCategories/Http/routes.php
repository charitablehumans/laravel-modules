<?php

Route::group(['middleware' => 'web', 'prefix' => 'productcategories', 'namespace' => 'Modules\ProductCategories\Http\Controllers'], function()
{
    Route::get('/', 'ProductCategoriesController@index');
});
