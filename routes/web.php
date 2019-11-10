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

use App\Exceptions\AdminException;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace'=>'Admin'],function() {
    Route::group(['prefix'=>'admin'],function() {
        //登录
        Route::get('login','LoginController@login');
        Route::get('getPublicKey','LoginController@getPublicKey');
        Route::post('sign','LoginController@sign');
        Route::get('logout','LoginController@logout')->name('logout');

        //需要检测登陆情况的路由
        Route::group(['middleware'=>['CheckLogin']],function() {
            //首页
            Route::get('index','IndexController@index');
            Route::get('welcome','IndexController@welcome')->name('welcome');


            //管理员模块
            Route::group(['prefix'=>'admin'],function() {
                Route::get('index','AdminController@index');
                Route::get('add','AdminController@add');
                Route::post('doAdd','AdminController@doAdd');
                Route::get('update/{id}','AdminController@update');
                Route::get('changeStatus','AdminController@changeStatus');
                Route::put('edit','AdminController@edit');
                Route::delete('delete','AdminController@delete');
                Route::delete('deleteAll','AdminController@deleteAll');
            });


            //角色模块
            Route::group(['prefix'=>'role'],function() {
                Route::get('index','RoleController@index');
                Route::get('add','RoleController@add');
                Route::post('doAdd','RoleController@doAdd');
                Route::get('update/{id}','RoleController@update');
                Route::get('changeStatus','RoleController@changeStatus');
                Route::put('doEdit','RoleController@doEdit');
                Route::delete('delete/{id}','RoleController@delete');
            });


            //权限模块
            Route::group(['prefix'=>'permission'],function() {
                Route::get('index','PermissionController@index');
                Route::get('add','PermissionController@add');
                Route::post('doAdd','PermissionController@doAdd');
                Route::get('update/{id}','PermissionController@update');
                Route::put('doEdit','PermissionController@doEdit');
                Route::delete('delete/{id}','PermissionController@delete');
            });
        });
    });
});

Route::get('/test',function() {
    throw new AdminException('管理员异常测试');
});
