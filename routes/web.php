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

/**
 * 文件上传
 */
Route::post('fileupload', ['as' => 'file.upload', 'uses' => 'FileController@fileupload']);
/**
 * 短信发送
 */
Route::post('shortMessage', ['as' => 'index.shortMessage', 'uses' => 'shortMessageController@index']);//->middleware('throttle:1,3')
/**
 * 前台管理路由设置
 */
Route::group(['namespace' => 'home'], function () {
    /*首页*/
    Route::get('/', 'IndexController@index');
    /*首页-注册*/
    Route::get('register', ['as' => 'index.register', 'uses' => 'RegisterController@index']);
    Route::post('verifivWhetExist', ['as' => 'index.verifivWhetExist', 'uses' => 'RegisterController@verifivWhetExist']);
    Route::post('regists/create', ['as' => 'index.regists.create', 'uses' => 'RegisterController@create']);
    Route::group(['prefix' => 'index'], function () {

    });


});
