@extends('home.public.subject')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/login.css') }}"/>
@endsection
@section('header')
@endsection
@section('content')
    <div class="container">
        <div class="loginTop">
            <img src="{{ asset('home/images/img/loginLogo.png') }}" alt=""/>
            <p>欢迎登录</p>
        </div>
    </div>
    <div class="mgt-20 loginTip">
        <p>为确保您账户的安全及正常使用，依《网络安全法》相关要求，6月1日起会员账户需绑定手机。如您还未绑定，请尽快完成，感谢您的理解及支持！</p>
    </div>
    <div class="loginBg">
        <div class="container relative">
            <div class="loginBox">
                <div class="loginNotice">
                    <img src="../images/img/loginNotice.png" alt=""/>
                    <p>阿郎博波不会以任何理由要求您转账汇款，谨防诈骗。</p>
                </div>
                <!--账户登录  手机登录 tab切换-->
                <ul id="myTab" class="nav nav-tabs loginTabList">
                    <li class="active">
                        <a href="#accountLogin" data-toggle="tab">
                            账户登录
                        </a>
                    </li>
                    <li>
                        <a href="#mobileLogin" data-toggle="tab">手机登陆</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <!--tab1 账户登录-->
                    <div class="tab-pane fade in active" id="accountLogin">
                        <div class="pdl-20 pdr-20">
                            <form action="" method="post">
                                <ul class="reg-box loginList">
                                    <li class="loginTel relative mgt-20">
                                        <i class="iconTel"></i>
                                        <input type="text" name="phone" id="phone" placeholder="手机号/用户名/邮箱" class="phone" autocomplete="off"/>
                                    </li>
                                    <li class="loginPassWord mgt-20 relative">
                                        <i class="iconTel iconPassword"></i>
                                        <input type="text"  name="password" id="password"  class = "password" placeholder="密码" autocomplete="off"/>
                                    </li>
                                </ul>
                                <a class="forgetWord mgt-20">忘记密码？</a>
                                <button type="submit" class="loginBtn mgt-20">立即登录</button>
                            </form>
                            <div class="register">
                                <a href="../html/register.html"><span>></span>立即注册</a>
                            </div>
                        </div>
                    </div>
                    <!--tab2 手机登录-->
                    <div class="tab-pane fade in" id="mobileLogin">
                        <div class="pdl-20 pdr-20">
                            <form action="" method="post">
                                <ul class="reg-box loginList">
                                    <li class="loginTel relative mgt-20">
                                        <i class="iconTel"></i>
                                        <input type="text" name="mobile" id="mobile" placeholder="手机号/用户名/邮箱" class="mobile" autocomplete="off"/>
                                    </li>
                                    <li class="loginPassWord mgt-20 relative">
                                        <i class="iconTel iconPassword"></i>
                                        <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode" name="verifyCode" autocomplete="off">
                                        <!--<button class="verifyBtn">获取验证码</button>-->
                                        <button class="teleCodeBtn get-code verifyBtn">获取验证码</button>
                                    </li>
                                </ul>
                                <a class="forgetWord mgt-20">忘记密码？</a>
                                <button type="submit" class="loginBtn mgt-20">立即登录</button>
                            </form>
                            <div class="register">
                                <a href="../html/register.html"><span>></span>立即注册</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <div class="copyRight container">
        <p class="copyRightTip">Copyright© 2002-2019，阿郎博波文化传媒（深圳）有限公司版权所有  |  浙公网安备 32010202010078号| 浙ICP备10207551号-4</p>
        <img src="{{ asset('home/images/img/bottomImg.png') }}" alt="" class="bottomImg"/>
    </div>
@endsection
@section('shop')
@endsection