<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('authentication/login', ['as' => 'frontend.authentication.login', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@login']);
    Route::post('authentication/login', ['as' => 'frontend.authentication.loginStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@loginStore']);
    Route::post('authentication/logout', ['as' => 'frontend.authentication.logoutStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@logoutStore']);
    Route::get('authentication/password/forgot', ['as' => 'frontend.authentication.passwordForgot', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordForgot']);
    Route::post('authentication/password/forgot', ['as' => 'frontend.authentication.passwordForgotStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordForgotStore']);
    Route::get('authentication/password/reset', ['as' => 'frontend.authentication.passwordReset', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordReset']);
    Route::put('authentication/password/reset', ['as' => 'frontend.authentication.passwordResetUpdate', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordResetUpdate']);
    Route::get('authentication/register', ['as' => 'frontend.authentication.register', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@register']);
    Route::post('authentication/register', ['as' => 'frontend.authentication.registerStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@registerStore']);
    Route::group(['middleware' => ['auth']], function () {
        Route::get('authentication/verify', ['as' => 'frontend.authentication.verify', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@verify']);
        Route::post('authentication/verify', ['as' => 'frontend.authentication.verifyStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@verifyStore']);
    });
});
