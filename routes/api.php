<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group([ 'middleware' => ['api', 'auth:api'] ], function ($router) {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@user');
});

