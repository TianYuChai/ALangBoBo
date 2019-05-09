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
                    <img src="{{ asset('home/images/img/loginNotice.png') }}" alt=""/>
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
                            <form method="post">
                                <ul class="reg-box loginList">
                                    <li class="loginTel relative mgt-20">
                                        <i class="iconTel"></i>
                                        <input type="text"
                                               name="account"
                                               id="account"
                                               placeholder="用户名/邮箱"
                                               class="phone"
                                               autocomplete="off"/>
                                    </li>
                                    <li class="loginPassWord mgt-20 relative">
                                        <i class="iconTel iconPassword"></i>
                                        <input type="password"  name="password" id="password" class = "password" placeholder="密码" autocomplete="off"/>
                                    </li>
                                </ul>
                                <input type="hidden" name="type" value="pass">
                                <a class="forgetWord mgt-20 forgetPass">忘记密码？</a>
                                <button type="submit" class="loginBtn mgt-20" onclick="return false;">立即登录</button>
                            </form>
                            <div class="register">
                                <a href="{{ route('index.register') }}"><span>></span>立即注册</a>
                            </div>
                        </div>
                    </div>
                    <!--tab2 手机登录-->
                    <div class="tab-pane fade in" id="mobileLogin">
                        <div class="pdl-20 pdr-20">
                            <form method="post">
                                <ul class="reg-box loginList">
                                    <li class="loginTel relative mgt-20">
                                        <i class="iconTel"></i>
                                        <input type="text" name="account" id="mobile" placeholder="手机号" class="mobile" autocomplete="off"/>
                                    </li>
                                    <li class="loginPassWord mgt-20 relative">
                                        <i class="iconTel iconPassword"></i>
                                        <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode" name="verifyCode" autocomplete="off">
                                        <!--<button class="verifyBtn">获取验证码</button>-->
                                        <button class="teleCodeBtn get-code verifyBtn" onclick="return false;">获取验证码</button>
                                    </li>
                                </ul>
                                <input type="hidden" name="type" value="short">
                                <a class="forgetWord mgt-20 forgetPass">忘记密码？</a>
                                <button type="submit" class="loginBtn mgt-20" onclick="return false;">立即登录</button>
                            </form>
                            <div class="register">
                                <a href="{{ route('index.register') }}"><span>></span>立即注册</a>
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

@section('section')
    <script type="text/javascript">
        $('.loginBtn').click(function () {
            var that = $(this);
            var data = that.parent('form').serializeArray();
            for (var i= 0; i< data.length; i++) {
                if(data[i]['value'] == "") {
                    layer.msg(comparison(data[i]['name']));return false;
                }
                if(data[i]['name'] == "mobile") {
                    if(!isPhoneNo(data[i]['value'])) {
                        layer.msg('请填写正确的手机号'); return;
                    }
                }
                if(data[i]['name'] == 'password') {
                    if(data[i]['value'].length < 6 || data[i]['value'].length > 12) {
                        layer.msg('密码错误'); return;
                    }
                }
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.login.operation') !!}",
                data:data,
                success:function (res) {
                    if(res.status == 200) {
                        window.location.href = res.url;
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
                        if(XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                        layer.msg(errors[0]);return;
                    }
                }
            });
        });
        /*监听-手机号*/
        $('#mobile').blur(function () {
            monitor('number', $(this).val());
        });
        /*监听-账号*/
        $("#account").blur(function () {
            monitor('account', $(this).val());
        });
        /*监听-提交*/
        function monitor(type, value)
        {
            var clas = type == 'number' ? "verifyBtn" : "loginBtn";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.login.verfMobile') !!}",
                data:{val: value, type: type},
                success:function (res) {
                    if(res.status == 200) {
                        $('.'+ clas).removeAttr('disabled');
                    }
                },
                error:function (XMLHttpRequest) {
                    $('.'+ clas).attr('disabled','disabled');
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                        layer.msg(errors[0]);return;
                    }
                }
            });
        }
        /*忘记密码*/
        $('.forgetPass').on('click', function () {
            layer.open({
                type: 2,
                title: '忘记密码',
                shadeClose: true,
                shade: 0.8,
                content: "{{ route('index.login.forgetpass') }}", //iframe的url
                area: ['1244px', '320px'], //宽高
            });
        });
        $('.verifyBtn').on('click', function () {
            var that = $(this);
            var mobile = $.trim($('#mobile').val());
            if(!mobile) {
                layer.msg('请填写手机号'); return;
            }
            if(!isPhoneNo(mobile)) {
                layer.msg('请填写正确的手机号'); return;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.shortMessage') !!}",
                data:{mobile: mobile},
                success:function (res) {
                    if(res.status == 200) {
                        layer.msg(res.info);
                        countDown(29, 59);
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                        layer.msg(errors[0]);return;
                    }
                }
            });
        });
        /*倒计时*/
        function countDown(m, s) {
            $('.verifyBtn').attr('disabled','disabled');
            var time = setInterval(function(){
                if(s < 10){
                    $('.verifyBtn').text(m+':0'+s);
                }else{
                    $('.verifyBtn').text(m+':'+s);
                }
                s--;
                if(s < 0) {
                    clearInterval(time);
                    $('.verifyBtn').text('获取验证码');
                    $('.verifyBtn').removeAttr('disabled');
                }
            }, 1000);
        }
    </script>
@endsection
