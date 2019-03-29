<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/3/28
 * Time: 10:30
 */

/**
 * 整个后台管理路由设置
 */
Route::group(['prefix' => 'backstage', 'namespace' => 'admin'], function () {
    /**
     * 登陆
     */
    Route::group(['namespace' => 'basic', 'middleware' => 'before'], function () {
        Route::get('login', ['as' =>'login', 'uses' => 'LoginController@index']);
        Route::post('land', ['as' => 'backstage.admin.login', 'uses' => 'LoginController@login']);
    });

    /**
     * 后台管理页面路由分组
     */
    Route::group(['middleware' => 'auth:backstage'], function () {
        Route::get('index', ['as' => 'backage.index.index', 'uses' => 'IndexController@index']);
    });
});
