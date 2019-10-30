<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace'=>'admin'],function() {
    Route::group(['prefix'=>'admin'],function() {

        //登录
        Route::get('login','LoginController@login');
        Route::get('getPublicKey','LoginController@getPublicKey');
        Route::post('sign','LoginController@sign');
        Route::get('logout','LoginController@logout');
    });
});
