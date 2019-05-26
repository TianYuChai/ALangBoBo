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
        /*黑名单*/
        Route::get('blackList/index', ['as' => 'backstage.blackList.index', 'uses' => 'other\blackListController@index']);
        Route::post('blackList/{id}/store', ['as' => 'backstage.blackList.store', 'uses' => 'other\blackListController@store']);
        Route::get('blackList/{id}/del', ['as' => 'backstage.blackList.del', 'uses' => 'other\blackListController@del']);
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
            Route::post('member/{id}/updateDistinguish', ['as' => 'backstage.member.updateDistinguish', 'uses' => 'MemberController@updateDistinguish']);
            /*会员-驳回记录*/
            Route::get('member/reject/index', ['as' => 'backstage.mreject.index', 'uses' => 'MemberRejectController@index']);
            Route::get('memeber/reject/{id}/cancel', ['as' => 'backstage.mreject.cancel', 'uses' => 'MemberRejectController@cancel']);
            /*会员-注销申请*/
            Route::get('member/cancel/index', ['as' => 'backstage.cancel.index', 'uses' => 'MemberCancelController@index']);
            Route::get('member/cancel/{id}/agree', ['as' => 'backstage.cancel.agree', 'uses' => 'MemberCancelController@agree']);
        });

        /**
         * 商品管理
         */
        Route::group(['namespace' => 'goods'], function () {
            /*商铺-商品*/
            Route::get('goods/index', ['as' => 'backstage.goods.index', 'uses' => 'GoodsAdminController@index']);
            Route::get('goods/{id}/operstatus', ['as' => 'backstage.goods.operstatus', 'uses' => 'GoodsAdminController@operstatus']);
            Route::get('goods/{id}/show', ['as' => 'backstage.goods.show', 'uses' => 'GoodsAdminController@show']);
            /*商铺*/
            Route::get('goods/merchant/index', ['as' => 'backstage.merchant.index', 'uses' => 'GoodsMerchantController@index']);
            Route::get('goods/{id}/show', ['as' => 'backstage.merchant.show', 'uses' => 'GoodsMerchantController@show']);
            /*商品-分类*/
            Route::get('goods/category/index', ['as' => 'backstage.category.index', 'uses' => 'GoodsCategoryController@index']);
            Route::get('goods/category/create', ['as' => 'backstage.category.create', 'uses' => 'GoodsCategoryController@create']);
            Route::post('goods/category/add', ['as' => 'backstage.category.add', 'uses' => 'GoodsCategoryController@add']);
            Route::get('goods/category/select', ['as' => 'backstage.category.select', 'uses' => 'GoodsCategoryController@select']);
            Route::get('goods/category/{id}/bannedOperation', ['as' => 'backstage.category.bannedOperation', 'uses' => 'GoodsCategoryController@bannedOperation']);
            Route::get('goods/category/{id}/edit', ['as' => 'backstage.category.edit', 'uses' => 'GoodsCategoryController@edit']);
            Route::post('goods/category/{id}/update', ['as' => 'backstage.category.update', 'uses' => 'GoodsCategoryController@update']);
            Route::get('goods/category/{id}/bannedAttriStatus', ['as' => 'backstage.category.bannedAttriStatus', 'uses' => 'GoodsCategoryController@bannedAttriStatus']);
            /*商品-横幅*/
            Route::group(['prefix' => 'banner'], function () {
                Route::get('goods/banner/index', ['as' => 'backstage.banner.index', 'uses' => 'GoodsBannerController@index']);
                Route::get('goods/banner/create', ['as' => 'backstage.banner.create', 'uses' => 'GoodsBannerController@create']);
                Route::post('goods/banner/store', ['as' => 'backstage.banner.store', 'uses' => 'GoodsBannerController@store']);
                Route::get('goods/banner/{id}/stateOperation', ['as' => 'backstage.banner.stateOperation', 'uses' => 'GoodsBannerController@stateOperation']);
                Route::get('goods/banner/{id}/del', ['as' => 'backstage.banner.del', 'uses' => 'GoodsBannerController@del']);
            });
        });
        /**
         * 系统设置
         */
        Route::group(['namespace' => 'setup'], function () {
            /*商家-入驻费*/
            Route::group(['prefix' => 'settled'], function () {
                Route::get('setup/settled/index', ['as' => 'backstage.settled.index', 'uses' => 'SettledInController@index']);
                Route::get('setup/settled/create', ['as' => 'backstage.settled.create', 'uses' => 'SettledInController@create']);
                Route::post('setup/settled/store', ['as' => 'backstage.settled.store', 'uses' => 'SettledInController@store']);
                Route::get('setup/settled/{id}/del', ['as' => 'backstage.settled.del', 'uses' => 'SettledInController@del']);
            });
        });
    });
});
