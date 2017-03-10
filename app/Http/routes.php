<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

/**
 * 显示所有任务
 */
Route::get('/home', 'HomeController@index');

/**
 * 任务管理
 */
Route::resource('task','TaskController',
    ['except' => ['show', 'create']]);

/**
 * 其他用户管理
 **/
Route::resource('admin','AdminController',
    ['only' => ['index','update','destroy']]);

/**
 * 地址管理
**/
Route::resource('addr','AddsController',
    ['only' => ['index', 'store','update','destroy']]);

/**
 *用户管理
 */
Route::resource('user','UserController',
    ['only' => ['index', 'store']]);

/**
 * 查找任务
 */
Route::post('search','HomeController@search');

/**
 * 测试路由
 */
Route::get('test',
    function(){
        return view('test');
    });