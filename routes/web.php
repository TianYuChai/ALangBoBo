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
    /*首页-注册*/
    Route::group(['middleware' => 'whiterlogin'], function () {
        Route::get('register', ['as' => 'index.register', 'uses' => 'RegisterController@index']);
        Route::post('verifivWhetExist', ['as' => 'index.verifivWhetExist', 'uses' => 'RegisterController@verifivWhetExist']);
        Route::post('regists/create', ['as' => 'index.regists.create', 'uses' => 'RegisterController@create']);
        Route::get('login', ['as' => 'index.login', 'uses' => 'LoginController@index']);
        Route::post('logi/operation', ['as' => 'index.login.operation', 'uses' => 'LoginController@operation']);
        Route::post('login/verfMobile', ['as' => 'index.login.verfMobile', 'uses' => 'LoginController@verfMobile']);
        Route::get('login/forgetPass', ['as' => 'index.login.forgetpass', 'uses' => 'LoginController@forgetPass']);
        Route::post('login/handleForgetPass', ['as' => 'index.login.handleforgetpass', 'uses' => 'LoginController@handleForgetPass']);
    });

    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('login/loginout', ['as' =>'index.login.loginout', 'uses' => 'LoginController@loginout']);
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
            Route::get('businresidfee', ['as' => 'personal.businresidfee', 'uses' => 'PesonalBusinResidFeeController@index']);
            Route::post('businresidfee/pay', ['as' => 'personal.businresidfee.pay', 'uses' => 'PesonalBusinResidFeeController@pay']);
            /*用户中心--商户*/
            Route::group(['namespace' => 'shop', 'middleware' => 'shop'], function () {
                /*店铺店招*/
                Route::get('shop/index', ['as' => 'personal.shop.index', 'uses'=> 'PersonalShopController@index']);
            });
        });
    });

});
