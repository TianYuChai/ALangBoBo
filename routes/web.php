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

Route::post('index', 'admin\IndexController@index');
/**
 * 文件上传
 */
Route::post('fileupload', ['as' => 'file.upload', 'uses' => 'FileController@fileupload']);
