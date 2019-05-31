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
//支付宝回调地址
Route::group(['namespace' => 'home\personal'], function () {
    Route::post('notify', ['as' => 'index.alipay.notify', 'uses' => 'PersonalCreditMarginController@notify']);
    Route::post('busin/notify', ['as' => 'index.busin.notify', 'uses' => 'PesonalBusinResidFeeController@notify']);
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
        });
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

                /*店铺商品*/
                Route::get('shop/goods', ['as' => 'personal.shop.goods', 'uses' => 'PersonalGoodsController@index']);
                Route::get('shop/goods/{id}/edit', ['as' =>'personal.goods.edit', 'uses' => 'PersonalGoodsController@edit']);
                Route::get('shop/goods/{id}/recom', ['as' => 'personal.goods.recom', 'uses' => 'PersonalGoodsController@recom']);
                /*入驻费是否缴纳或到期*/
                Route::group(['middleware' => 'whetherdueto'], function () {
                    Route::post('shop/goods/select', ['as' => 'personal.goods.select', 'uses' => 'PersonalGoodsController@select']);
                    Route::post('shop/goods/attribute', ['as' => 'personal.goods.attribute', 'uses' => 'PersonalGoodsController@attribute']);
                    Route::post('shop/goods/store', ['as' => 'personal.goods.store', 'uses' => 'PersonalGoodsController@store']);
                    Route::get('shop/goods/{id}/operStatus', ['as' => 'personal.goods.operstatus', 'uses' => 'PersonalGoodsController@operstatus']);
                    Route::post('shop/goods/{id}/update', ['as' => 'personal.goods.update', 'uses' => 'PersonalGoodsController@update']);
                    Route::get('shop/goods/{id}/delattribute', ['as' => 'personal.goods.delattribute', 'uses' => 'PersonalGoodsController@delAttribute']);
                });
                /*店铺推广*/
                Route::get('shop/generalize', ['as' => 'personal.shop.generalize', 'uses' => 'PersonalGeneralizeController@index']);
                Route::post('shop/generalize/store', ['as' => 'personal.generalize.store', 'uses' => 'PersonalGeneralizeController@store']);
            });
        });
    });

});
