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
Route::post('delfile', ['as' => 'file.del', 'uses' => 'FileController@del']);
/**
 * 短信发送
 */
Route::post('shortMessage', ['as' => 'index.shortMessage', 'uses' => 'shortMessageController@index'])->middleware('throttle:1,3');//
//人脸识别
Route::post('faceRecognition', ['as' => 'index.face', 'uses' => 'faceRecognitionController@index']);
//回调地址
Route::group(['namespace' => 'home'], function () {
    Route::post('notify', ['as' => 'index.alipay.notify', 'uses' => 'personal\PersonalCreditMarginController@notify']);
    Route::post('busin/notify', ['as' => 'index.busin.notify', 'uses' => 'personal\PesonalBusinResidFeeController@notify']);
    Route::post('order/notify', ['as' => 'index.order.notify', 'uses' => 'shoppingController@notify']);
    Route::post('subscribed/order/notify', ['as' => 'index.subscribed.notify', 'uses' => 'personal\PersonalHaveGoodsController@notify']);
    Route::post('demand/alinotify', ['as' => 'index.demand.alinotify', 'uses' => 'demandController@aliNotify']);
    Route::post('wxnotify', ['as' => 'index.wx.notify', 'uses' => 'personal\PersonalCreditMarginController@wxnotify']);
    Route::post('busin/wxnotify', ['as' => 'index.busin.wxnotify', 'uses' => 'personal\PesonalBusinResidFeeController@wxnotify']);
    Route::post('order/wxnotify', ['as' => 'index.order.wxnotify', 'uses' => 'shoppingController@wxnotify']);
});
/**
 * 前台管理路由设置
 */
Route::group(['namespace' => 'home', 'middleware' => 'listenState'], function () {
    /*首页*/
    Route::get('/', 'IndexController@index');
    Route::get('theBlacklist', 'theblackistController@index');
    Route::get('product/{type}', 'ProductController@index');
    Route::get('details/{id}', 'ProductController@show');
    Route::get('partime', 'parTimeListController@index');
    Route::get('partime/{id}', ['as' =>'partime.show', 'uses' => 'parTimeListController@show']);
    Route::get('merchant', 'merchantController@index');
    Route::get('merchant/{id}', ['as' => 'merchant.show', 'uses' => 'merchantController@show']);
    Route::get('merchant/{id}/evenmore', ['as' =>'merchant.evenmore', 'uses' => 'merchantController@evenMore']);
    Route::get('demand', 'demandController@index');
    Route::get('demand/{id}/show', ['as' => 'demand.show', 'uses' => 'demandController@show']);
    Route::get('button/{id}', ['as' => 'index.button', 'uses' => 'IndexController@button']);
    /*首页-注册*/
    Route::group(['middleware' => 'whiterlogin'], function () {
        Route::get('register', ['as' => 'index.register', 'uses' => 'RegisterController@index']);
        Route::post('verifivWhetExist', ['as' => 'index.verifivWhetExist', 'uses' => 'RegisterController@verifivWhetExist']);
        Route::post('regists/create', ['as' => 'index.regists.create', 'uses' => 'RegisterController@create']);
        Route::get('login', ['as' => 'index.login', 'uses' => 'LoginController@index']);
        Route::post('login/operation', ['as' => 'index.login.operation', 'uses' => 'LoginController@operation']);
        Route::post('login/verfMobile', ['as' => 'index.login.verfMobile', 'uses' => 'LoginController@verfMobile']);
        Route::get('login/forgetPass', ['as' => 'index.login.forgetpass', 'uses' => 'LoginController@forgetPass']);
        Route::post('login/handleForgetPass', ['as' => 'index.login.handleforgetpass', 'uses' => 'LoginController@handleForgetPass']);
    });

    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('login/loginout', ['as' =>'index.login.loginout', 'uses' => 'LoginController@loginout']);
        Route::post('theBlacklist/selectShop', ['as' => 'index.theBlacklist.select', 'uses' => 'theblackistController@selectShop']);
        Route::post('theBlacklist/merchantStore', ['as' => 'index.theBlacklist.merchantStore', 'uses' => 'theblackistController@merchantStore']);
        Route::post('theBlacklist/selectUser', ['as' => 'index.theBlacklist.selectuser', 'uses' => 'theblackistController@selectUser']);
        Route::post('theBlacklist/userStore', ['as' => 'index.theBlacklist.userStore', 'uses' => 'theblackistController@userStore']);
        Route::group(['prfix' => 'shopp'], function () {
            Route::post('shopp/{id}/buyNow', ['as' => 'shopp.shopp.buynow', 'uses' => 'shoppingController@buyNow']);
            Route::get('shopp/{order_id}/confirmOrder', ['as' => 'shopp.shopp.confirmorder', 'uses' =>'shoppingController@confirmOrder']);
            Route::post('shopp/{order_id}/store', ['as' => 'shopp.shopp.store', 'uses' => 'shoppingController@store']);
            Route::post('shopp/{id}/shoppcart', ['as' => 'shopp.shopp.cart', 'uses' => 'shoppingController@shoppCart']);
            Route::get('shopp/shoppcar', ['as' => 'shopp.shopp.car', 'uses' => 'shoppingController@shoppCar']);
            Route::post('shopp/delgoods', ['as' => 'shopp.shopp.delgoods', 'uses' => 'shoppingController@delGoods']);
            Route::post('shopp/shoppsettlement', ['as' => 'shopp.shopp.shoppsettlement', 'uses' => 'shoppingController@shoppSettlement']);
        });
        /*投递*/
        Route::get('parttime/{id}/send', ['as' => 'partime.send', 'uses' => 'parTimeListController@send']);
        /*需求*/
        Route::get('demand/{id}/send', ['as' => 'demand.send', 'uses' => 'demandController@send']);
        Route::group(['namespace' => 'personal', 'prefix' => 'personal'], function () {
            /*用户中心*/
            Route::get('index', ['as' => 'personal.index', 'uses' => 'PersonalContentController@index']);
            Route::get('merchant_data', ['as' => 'personal.merchant_data', 'uses' => 'PersonalContentController@merchantData']);
            Route::post('pictureUpload', ['as' => 'personal.pictureUpload', 'uses' => 'PersonalContentController@pictureUpload']);
            Route::post('homeLive', ['as' => 'personal.homeLive', 'uses' => 'PersonalContentController@homeLive']);
            Route::get('address', ['as' => 'personal.address', 'uses' => 'PersonalContentController@address']);
            Route::get('address/{id}/del', ['as' => 'personal.addressdel', 'uses' => 'PersonalContentController@addressDel']);
            Route::post('createAddress', ['as' => 'personal.createaddress', 'uses' => 'PersonalContentController@createAddress']);
            Route::get('handleAddress{id}', ['as' => 'personal.handleaddress', 'uses' => 'PersonalContentController@handleAddress']);
            Route::get('cancellationUser', ['as' => 'personal.cancellationuser', 'uses' => 'PersonalContentController@cancellationUser']);
            Route::post("cancellHandleUser", ['as' => 'personal.cancellhandleuser', 'uses' => 'PersonalContentController@cancellHandleUser']);
            Route::get("creditMargin", ['as' => 'personal.creditmargin', 'uses' => 'PersonalCreditMarginController@index']);
            Route::post('pay', ['as' => 'personal.pay', 'uses' => 'PersonalCreditMarginController@pay']);
            Route::post('cashWithdrawal', ['as' => 'personal.cashWithdrawal', 'uses' => 'PersonalContentController@cashWithdrawal']);

            Route::get('businresidfee', ['as' => 'personal.businresidfee', 'uses' => 'PesonalBusinResidFeeController@index'])->middleware('judgemerchant');
            Route::post('businresidfee/pay', ['as' => 'personal.businresidfee.pay', 'uses' => 'PesonalBusinResidFeeController@pay'])->middleware('judgemerchant');
            Route::get('merchant', ['as' => 'personal.merchant', 'uses' => 'PersonalMerchantController@index'])->middleware("judgeordinuser");
            Route::post('store', ['as' => 'personal.store', 'uses' => 'PersonalMerchantController@store'])->middleware("judgeordinuser");
            Route::get('{type}/havegoods', ['as' => 'personal.havegoods', 'uses' => 'PersonalHaveGoodsController@index']);
            Route::get('havegoods/{id}/show', ['as' => 'personal.havegoods.show', 'uses' => 'PersonalHaveGoodsController@show']);
            Route::get('havegoods/{id}/sign', ['as' => 'personal.havegoods.sign', 'uses' => 'PersonalHaveGoodsController@sign']);
            Route::get('havegoods/{id}/delorder', ['as' => 'personal.havegoods.delorder', 'uses' => 'PersonalHaveGoodsController@delOrder']);
            Route::post('havegoods/{id}/refundOrder', ['as' => 'personal.havegoods.refundorder', 'uses' => 'PersonalHaveGoodsController@refundOrder']);
            Route::post('havegoods/{id}/evaluation', ['as' => 'personal.havegoods.evaluation', 'uses' => 'PersonalHaveGoodsController@evaluation']);
            Route::get('havegoods/{id}/pay', ['as' => 'personal.havegoods.pay', 'uses' => 'PersonalHaveGoodsController@pay']);
            Route::get('sendtime', ['as' => 'personal.sendtime.index', 'uses' => 'PersonalSendTimeController@index']);
            Route::get('sendtime/{id}/del', ['as' =>'personal.sendtime.del' , 'uses' => 'PersonalSendTimeController@del']);
            Route::get('demand', ['as' => 'personal.demand.index', 'uses' => 'demandOperationController@index']);
            Route::get('demand/{id}/del', ['as' => 'personal.demand.del', 'uses' => 'demandOperationController@del']);
            Route::post('demand/store', ['as' => 'personal.demand.store', 'uses' => 'demandOperationController@store']);
            Route::get('demand/{id}/immediatelypay', ['as' => 'personal.demand.immediatelypay', 'uses' => 'demandOperationController@immediatelyPay']);
            Route::get('demand/{id}/edit', ['as' => 'personal.demand.edit', 'uses' => 'demandOperationController@edit']);
            Route::post('demand/{id}/update', ['as' => 'personal.demand.update', 'uses' => 'demandOperationController@update']);
            Route::get('demand/{id}/confirm', ['as' => 'personal.demand.confirm', 'uses' => 'demandOperationController@confirm']);
            Route::post('demand/{id}/high', ['as' => 'personal.demand.high', 'uses' => 'demandOperationController@high']);
            Route::get('demand/list', ['as' => 'personal.demand.list', 'uses' => 'demandOperationController@list']);
            /*用户中心--商户*/
            Route::group(['namespace' => 'shop', 'middleware' => 'shop'], function () {
                /*店铺店招*/
                Route::get('shop/index', ['as' => 'personal.shop.index', 'uses'=> 'PersonalShopController@index']);
                Route::post('shop/updateTrademark', ['as' => 'personal.shop.updateTrademark', 'uses' => 'PersonalShopController@updateTrademark']);
                Route::post('shop/update', ['as' => 'personal.shop.update', 'uses' => 'PersonalShopController@update']);
                /*店铺分类*/
                Route::get('shop/menu', ['as' => 'personal.shop.menu', 'uses' => 'PersonalMenuController@index']);
                Route::post('shop/menu/store', ['as' => 'personal.menu.store', 'uses' => 'PersonalMenuController@store']);
                Route::get('shop/mene/{id}/edit', ['as' => 'personal.menu.edit', 'uses' => 'PersonalMenuController@edit']);
                Route::post('shop/menu/{id}/update', ['as' => 'personal.menu.update', 'uses' => 'PersonalMenuController@update']);
                Route::get('shop/menu/{id}/del', ['as' => 'personal.menu.del', 'uses' => 'PersonalMenuController@del']);
                /*店铺轮播图*/
                Route::get('shop/banner', ['as' => 'personal.shop.banner', 'uses' => 'PersonalBannerController@index']);
                Route::post('shop/banner/store', ['as' => 'personal.banner.store', 'uses' => 'PersonalBannerController@store']);
                Route::get('shop/banner/{id}/edit', ['as' => 'personal.banner.edit', 'uses' => 'PersonalBannerController@edit']);
                Route::post('shop/banner/{id}/update', ['as' => 'personal.banner.update', 'uses' => 'PersonalBannerController@update']);
                Route::get('shop/banner/{id}/del', ['as' => 'personal.banner.del', 'uses' => 'PersonalBannerController@del']);
                /*店铺订单*/
                Route::get('shop/{type}/order', ['as' => 'personal.shop.order', 'uses' => 'PersonalOrderController@index']);
                Route::post('shop/{id}/deliveryOrder', ['as' => 'personal.order.deliveryorder', 'uses' => 'PersonalOrderController@deliveryOrder']);
                Route::post('shop/{id}/editDeliveryOrder', ['as' => 'personal.order.editdeliveryorder', 'uses' => 'PersonalOrderController@editDeliveryOrder']);
                Route::get('shop/{id}/reimburse', ['as' => 'personal.order.reimburse', 'uses' => 'PersonalOrderController@reimburse']);
                /*店铺商品*/
                Route::get('shop/goods', ['as' => 'personal.shop.goods', 'uses' => 'PersonalGoodsController@index']);
                Route::get('shop/goods/{id}/edit', ['as' =>'personal.goods.edit', 'uses' => 'PersonalGoodsController@edit']);
                Route::get('shop/goods/{id}/recom', ['as' => 'personal.goods.recom', 'uses' => 'PersonalGoodsController@recom']);
                /*兼职管理*/
                Route::get('shop/parttime/index', ['as' =>'personal.partime.index', 'uses' => 'PersonalPartTimeController@index']);
                Route::get('shop/parttime/{id}/show', ['as' => 'personal.partime.show', 'uses' => 'PersonalPartTimeController@show']);
                /*入驻费是否缴纳或到期*/
                Route::group(['middleware' => 'whetherdueto'], function () {
                    Route::post('shop/goods/select', ['as' => 'personal.goods.select', 'uses' => 'PersonalGoodsController@select']);
                    Route::post('shop/goods/attribute', ['as' => 'personal.goods.attribute', 'uses' => 'PersonalGoodsController@attribute']);
                    Route::post('shop/goods/store', ['as' => 'personal.goods.store', 'uses' => 'PersonalGoodsController@store']);
                    Route::get('shop/goods/{id}/operStatus', ['as' => 'personal.goods.operstatus', 'uses' => 'PersonalGoodsController@operstatus']);
                    Route::post('shop/goods/{id}/update', ['as' => 'personal.goods.update', 'uses' => 'PersonalGoodsController@update']);
                    Route::get('shop/goods/{id}/delattribute', ['as' => 'personal.goods.delattribute', 'uses' => 'PersonalGoodsController@delAttribute']);
                    Route::post('shop/parttime/create', ['as' => 'personal.partime.create', 'uses' => 'PersonalPartTimeController@create']);
                    Route::get('shop/partime/{id}/edit', ['as' => 'personal.partime.edit', 'uses' => 'PersonalPartTimeController@edit']);
                    Route::post('shop/partime/{id}/update', ['as' => 'personal.partime.update', 'uses' => 'PersonalPartTimeController@update']);
                    Route::get('shop/partime/{id}/del', ['as' => 'personal.partime.del', 'uses' => 'PersonalPartTimeController@del']);
                });
                /*店铺推广*/
                Route::get('shop/generalize', ['as' => 'personal.shop.generalize', 'uses' => 'PersonalGeneralizeController@index']);
                Route::post('shop/generalize/store', ['as' => 'personal.generalize.store', 'uses' => 'PersonalGeneralizeController@store']);
            });
        });
    });

});
