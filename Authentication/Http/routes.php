<?php

use Modules\Authentication\Http\Middleware\ApiAuthenticationRegisterTrue;

Route::group(['middleware' => ['api']], function () {
    Route::post('api/authentication/login', ['as' => 'api.authentication.login', 'uses' => '\Modules\Authentication\Http\Controllers\Api\AuthenticationController@login']);
    Route::post('api/authentication/password/forgot', ['as' => 'api.authentication.passwordForgot', 'uses' => '\Modules\Authentication\Http\Controllers\Api\AuthenticationController@passwordForgot']);
    Route::post('api/authentication/password/reset', ['as' => 'api.authentication.passwordReset', 'uses' => '\Modules\Authentication\Http\Controllers\Api\AuthenticationController@passwordReset']);
    Route::post('api/authentication/register', [
        'as' => 'api.authentication.register',
        'middleware' => ApiAuthenticationRegisterTrue::class,
        'uses' => '\Modules\Authentication\Http\Controllers\Api\AuthenticationController@register',
    ]);
    Route::post('api/authentication/socialite/register', [
        'as' => 'api.authentication.socialite.registerStore',
        'middleware' => ApiAuthenticationRegisterTrue::class,
        'uses' => '\Modules\Authentication\Http\Controllers\Api\SocialiteController@registerStore',
    ]);
    Route::post('api/authentication/verified', ['as' => 'api.authentication.verified', 'uses' => '\Modules\Authentication\Http\Controllers\Api\AuthenticationController@verified']);
    Route::post('api/authentication/verify', ['as' => 'api.authentication.verify', 'uses' => '\Modules\Authentication\Http\Controllers\Api\AuthenticationController@verify']);
});

Route::group(['middleware' => ['web']], function () {
    Route::get('authentication/login', ['as' => 'frontend.authentication.login', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@login']);
    Route::post('authentication/login', ['as' => 'frontend.authentication.loginStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@loginStore']);
    Route::get('authentication/login/{social}', ['as' => 'frontend.authentication.loginSocial', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\SocialiteController@redirectToProvider'])->where('social', 'facebook|github|google');
    Route::get('authentication/login/{social}/callback', ['as' => 'frontend.authentication.loginSocialCallback', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\SocialiteController@handleProviderCallback'])->where('social', 'facebook|github|google');
    Route::post('authentication/logout', ['as' => 'frontend.authentication.logoutStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@logoutStore']);
    Route::get('authentication/password/forgot', ['as' => 'frontend.authentication.passwordForgot', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordForgot']);
    Route::post('authentication/password/forgot', ['as' => 'frontend.authentication.passwordForgotStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordForgotStore']);
    Route::get('authentication/password/reset', ['as' => 'frontend.authentication.passwordReset', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordReset']);
    Route::put('authentication/password/reset', ['as' => 'frontend.authentication.passwordResetUpdate', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@passwordResetUpdate']);
    Route::get('authentication/register', ['as' => 'frontend.authentication.register', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@register']);
    Route::post('authentication/register', ['as' => 'frontend.authentication.registerStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@registerStore']);
    Route::get('authentication/verify', ['as' => 'frontend.authentication.verify', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@verify']);
    Route::post('authentication/verify', ['as' => 'frontend.authentication.verifyStore', 'uses' => '\Modules\Authentication\Http\Controllers\Frontend\AuthenticationController@verifyStore']);
});
