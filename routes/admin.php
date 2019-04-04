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
        Route::get('index', ['as' => 'backstage.index.index', 'uses' => 'IndexController@index']);
        Route::get('welcome', ['as' => 'backstage.index.welcome', 'uses' => 'IndexController@welcome']);
        Route::get('logout', ['as' => 'backstage.login.out', 'uses' => 'basic\LoginController@logout']);
        /**
         * 会员管理
         */
        Route::group(['namespace' => 'member'], function () {
            /*会员-管理*/
            Route::get('member/index', ['as' => 'backstage.member.index', 'uses' => 'MemberController@index']);
            Route::get('member/{id}/adopt', ['as' => 'backstage.member.adopt', 'uses' => 'MemberController@adopt']);
            Route::post('member/{id}/reject', ['as' => 'backstage.member.reject', 'uses' => 'MemberController@reject']);
            Route::post('member/{id}/edit_pass', ['as' => 'backstage.member.edit_pass', 'uses' => 'MemberController@edit_pass']);
            Route::get('member/{id}/sealUp', ['as' => 'backstage.member.sealUp', 'uses' => 'MemberController@sealUp']);
            Route::get('member/{id}/stop', ['as' => 'backstage.member.stop', 'uses' => 'MemberController@stop']);
            Route::get('member/{id}/see', ['as' => 'backstage.member.see', 'uses' => 'MemberController@see']);
            /*会员-驳回记录*/
            Route::get('member/reject/index', ['as' => 'backstage.mreject.index', 'uses' => 'MemberRejectController@index']);
            Route::get('memeber/reject/{id}/cancel', ['as' => 'backstage.mreject.cancel', 'uses' => 'MemberRejectController@cancel']);
        });

        /**
         * 商品管理
         */
        Route::group(['namespace' => 'goods'], function () {
            /*商品-分类*/
            Route::get('goods/category/index', ['as' => 'backstage.category.index', 'uses' => 'GoodsCategoryController@index']);
            Route::get('goods/category/create', ['as' => 'backstage.category.create', 'uses' => 'GoodsCategoryController@create']);
        });
    });
});
