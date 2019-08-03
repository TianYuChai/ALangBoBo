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
        Route::post('editPass', ['as' => 'backstage.login.editpass', 'uses' => 'basic\LoginController@editPass']);
        /*黑名单*/
        Route::get('blackList/index', ['as' => 'backstage.blackList.index', 'uses' => 'other\blackListController@index']);
        Route::post('blackList/{id}/store', ['as' => 'backstage.blackList.store', 'uses' => 'other\blackListController@store']);
        Route::get('blackList/{id}/del', ['as' => 'backstage.blackList.del', 'uses' => 'other\blackListController@del']);
        /*投诉与建议*/
        Route::get('complain/index', ['as' => 'backstage.complain.index', 'uses' => 'other\complainController@index']);
        Route::post('complain/{id}/{type}/handle', ['as' => 'backstage.complain.handle', 'uses' => 'other\complainController@handle']);
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
            /*会员-流水*/
            Route::get('member/{id}/runningWater', ['as' => 'backstage.member.water', 'uses' => 'MemberController@runningWater']);
            /*会员-修改绑定手机*/
            Route::post('member/{id}/editMobile', ['as' => 'backstage.member.editmobile', 'uses' => 'MemberController@editMobile']);
        });

        /**
         * 商品管理
         */
        Route::group(['namespace' => 'goods'], function () {
            /*商铺-商品*/
            Route::get('goods/index', ['as' => 'backstage.goods.index', 'uses' => 'GoodsAdminController@index']);
            Route::get('goods/{id}/operstatus', ['as' => 'backstage.goods.operstatus', 'uses' => 'GoodsAdminController@operstatus']);
            Route::get('goods/{id}/look', ['as' => 'backstage.goods.look', 'uses' => 'GoodsAdminController@show']);
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
            //兼职
            Route::get('goods/parttime/index', ['as' => 'backstage.parttime.index', 'uses' => 'partTimeController@index']);
            Route::get('goods/parttime/{id}/show', ['as' => 'backstage.parttime.show', 'uses' => 'partTimeController@show']);
            //百录倩影
            Route::get('goods/demand/index', ['as' => 'backstage.demand.index', 'uses' => 'demandAdminController@index']);
            Route::get('goods/demand/{id}/show', ['as' => 'backstage.demand.show', 'uses' => 'demandAdminController@show']);
        });
        /*商铺-订单*/
        Route::group(['namespace' => 'order'], function () {
            Route::get('order/index', ['as' => 'backstage.order.index', 'uses' => 'orderController@index']);
            Route::get('order/{id}/show', ['as' => 'backstage.order.show', 'uses' => 'orderController@show']);
            Route::post('order/{id}/addtime', ['as' => 'backstage.order.addtime', 'uses' => 'orderController@addtime']);
            Route::get('order/{id}/cancelorder', ['as' => 'backstage.order.cancelorder', 'uses' => 'orderController@cancelOrder']);
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
                Route::get('setup/issue/shopp_guide/index', ['as' => 'backstage.shopp_guide.index', 'uses' => 'issueController@index']);
                Route::get('setup/issue/shopp_guide/duitecteate', ['as' =>'backstage.shopp_guide.duitecteate', 'uses' => 'issueController@duiteCteate']);
                Route::post('setup/issue/shopp_guide/duitestore', ['as' => 'backstage.shopp_guide.duitestore', 'uses' => 'issueController@duiteStore']);
                Route::get('setup/issue/shopp_guide/{id}/duiteedit', ['as' => 'backstage.shopp_guide.duiteedit', 'uses' => 'issueController@duiteEdit']);
                Route::post('setup/issue/shopp_guide/{id}/duiteupdate', ['as' => 'backstage.shopp_guide.duiteupdate', 'uses' => 'issueController@duiteUpdate']);
                Route::get('setup/issue/shopp_guide/{id}/duitedel', ['as' => 'backstage.shopp_guide.duitedel', 'uses' => 'issueController@duiteDel']);
                Route::get('setup/issue/merchantService/index', ['as' => 'backstage.merchantService.index', 'uses' => 'issueController@merchantService']);
            });
            /*客服设置*/
            Route::get('kefu/index', ['as' => 'backstage.kefu.index', 'uses' => 'keFuController@index']);
            Route::post('kefu/store', ['as' => 'backstage.kefu.store', 'uses' => 'keFuController@store']);
        });
    });
});
