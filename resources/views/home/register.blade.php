@extends('home.public.subject')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/register.css') }}"/>
@endsection
@section('content')
<div class="container">
    <div class="tittle">
        <img src="{{ asset('home/images/img/logo.png') }}" alt=""/>
        <p>用户注册</p>
    </div>
    <!--注册步骤-->
    <div class="registerStep">
        <!--第一步-->
        <!--通过添加 类 hidden 控制其它步骤隐藏-->
        <div class="stepPart mgb-300 user_info">
            <!--1.设置用户名-->
            <div class="level1 clearfix">
                <div class="mgl-250">
                    <!--注册第一步，当前样式类名：stepActive 根据步骤替换即可-->
                    <div class="fl step1 stepActive"><p><span>1</span>设置用户名</p></div>
                    <div class="fl step2"><p><span>2</span>填写账号信息</p></div>
                    <div class="fl step3"><p><span>3</span>注册完成</p></div>
                </div>
            </div>
            <div class="step1Div">
                <form class="cmxform" id="user_info">
                    <fieldset class="fieldset clearfix">
                        <div class="accountDiv relative">
                            账号
                            <input type="text" placeholder="请输入账号"
                                   class="account"
                                   name="account"
                                   autocomplete="off">
                        </div>
                        <div class="passwordDiv mgt-30 relative">
                            密码
                            <input type="password" placeholder="请输入密码"
                                   class="password"
                                   name="password"
                                   autocomplete="off">
                        </div>
                        <div class="shopChoice">
                            <input type="radio" value="0" name="category" checked/>
                            <label for="" class="mgr-30">买家</label>
                            <input type="radio" value="1" name="category"/>
                            <label for="" class="mgr-30">企业商户</label>
                            <input type="radio" value="2" name="category"/>
                            <label for="" class="mgr-30">个人商户</label>
                        </div>
                        <div class="step1Btn">
                            <button class="submit stepBtnActive"
                                    type="submit"
                                    onClick="return false;" data-stage="user_info">下一步</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!--第二步-->
        <div class="stepPart hidden account_info">
            <!--2.填写账号信息-->
            <div class="level1 clearfix">
                <div class="mgl-250">
                    <!--注册第二步，第一，三步已隐藏 ，当前样式类名：stepActive 根据步骤替换即可-->
                    <div class="fl step1 stepActive"><p><span>1</span>设置用户名</p></div>
                    <div class="fl step2 stepActive"><p><span>2</span>填写账号信息</p></div>
                    <div class="fl step3"><p><span>3</span>注册完成</p></div>
                </div>
            </div>
            <!--当注册第一步选择的是 买家 ，则显示此第二步样式-->
            <!--当注册第一步选择的是 买家 ，同样其它两个样式 hidden 隐藏-->
            <div class="step2Div hidden buyer_info">
                <form class="cmxform" id="buyer_info">
                    <fieldset class="fieldset clearfix">
                        <p class="userInfo">用户资料填写：</p>
                        <div class="nameDiv relative">
                            姓名
                            <input type="text" placeholder="请输入姓名" class="name" id="name" name="name" autocomplete="off">
                        </div>
                        <div class="idDiv mgt-30 relative">
                            身份证号
                            <input type="text" placeholder="请输入身份证号" class="password" id="id" name="id" autocomplete="off">
                        </div>
                        <div class="mobileDiv relative mgt-30">
                            手机号
                            <input type="text" placeholder="请输入手机号" class="mobile" id="mobile" name="mobile" autocomplete="off">
                        </div>
                        <div class="mgt-30 relative verifyCodeDiv">
                            验证码
                            <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode" name="verifyCode" autocomplete="off">
                            <!--<button class="verifyBtn">获取验证码</button>-->
                            <button class="teleCodeBtn get-code verifyBtn" onClick="return false;">获取验证码</button>
                        </div>
                        <div class="xieyiDiv">
                            <input type="checkbox" name="type" value="1" class="type" checked/>
                            <label for="">我已阅读和同意 <a href="">《注册协议》</a></label>
                        </div>
                        <div class="step2Btn">
                            <button class="submit stepBtnActive"
                                    onClick="return false;"
                                    data-stage="buyer_info">确定</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <!--当注册第一步选择的是 企业商户 ，则显示此第二步样式-->
            <!--当注册第一步选择的是 企业商户 ，同样其它两个样式 hidden 隐藏-->
            <div class="step2Div hidden enterprise_info">
                <form class="cmxform" id="qiyeVerifyForm2">
                    <fieldset class="fieldset clearfix">
                        <p class="userInfo">企业商户资料填写：</p>
                        <div class="nameDiv relative">
                            姓名
                            <input type="text" placeholder="请输入姓名" class="name" id="qiyeName" name="name" autocomplete="off">
                        </div>
                        <div class="idDiv mgt-30 relative">
                            身份证号
                            <input type="text" placeholder="请输入身份证号" class="password" id="qiyeId" name="id" autocomplete="off">
                        </div>
                        <div class="idImgDiv mgt-30 relative">
                            <div class="relative">
                                <p class="inline-block mgr-20">身份证正面</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" id="zheng" name="zheng">
                                <input type="file" class="file-input" /> 
                            </div>
                            <div class="relative">
                                <p class="inline-block mgr-20">身份证反面</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" id="fan" name="fan">
                            </div>
                        </div>
                        <div class="mobileDiv relative mgt-30">
                            手机号
                            <input type="text" placeholder="请输入手机号" class="mobile" id="qiyeMobile" name="mobile" autocomplete="off">
                        </div>
                        <div class="mgt-30 relative verifyCodeDiv">
                            验证码
                            <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode2" name="verifyCode" autocomplete="off">
                            <!--<button class="verifyBtn">获取验证码</button>-->
                            <button class="teleCodeBtn get-code verifyBtn">获取验证码</button>
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">人脸识别</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" id="renlian" name="renlian">
                        </div>
                        <div class="nameDiv relative mgt-30">
                            店名
                            <input type="text" placeholder="请输入店名" class="name" id="shopName" name="shopName" autocomplete="off">
                        </div>
                        <div class="idDiv mgt-30 relative">
                            统一社会信用代码
                            <input type="text" placeholder="请输入统一社会信用代码" class="shehuiDaima" id="shehuiDaima" name="shehuiDaima" autocomplete="off">
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">营业执照上传</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" id="yyzz" name="yyzz">
                        </div>
                        <div class="idImgDiv mgt-30 relative">
                            <div class="relative">
                                <p class="inline-block">食品行业证件上传</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" id="food" name="food">
                            </div>
                            <div class="relative">
                                <p class="inline-block">美容或理发行业</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" id="mrlf" name="mrlf">
                            </div>
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block">其它行业证件上传</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" id="qt" name="qt">
                        </div>
                        <div class="xieyiDiv">
                            <input type="checkbox" name="type" value="1" class="type" checked/>
                            <label for="">我已阅读和同意 <a href="">《注册协议》</a></label>
                        </div>
                        <div class="step2Btn">
                            <button class="submit stepBtnActive"
                                    onClick="return false;"
                                    data-stage="enterprise_info" >确定</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <!--当注册第一步选择的是 个人商户 ，则显示此第二步样式-->
            <!--当注册第一步选择的是 个人商户 ，同样其它两个样式 hidden 隐藏-->
            <div class="step2Div hidden personal_info">
                <form class="cmxform" id="gerenVerifyForm2" method="get" action="">
                    <fieldset class="fieldset clearfix">
                        <p class="userInfo">个人商户资料填写：</p>
                        <div class="nameDiv relative">
                            姓名
                            <input type="text" placeholder="请输入姓名" class="name" id="gerenName" name="name" autocomplete="off">
                        </div>
                        <div class="idDiv mgt-30 relative">
                            身份证号
                            <input type="text" placeholder="请输入身份证号" class="password" id="gerenId" name="id" autocomplete="off">
                        </div>
                        <div class="idImgDiv mgt-30 relative">
                            <div class="relative">
                                <p class="inline-block mgr-20">身份证正面</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" id="zheng2" name="zheng">
                            </div>
                            <div class="relative">
                                <p class="inline-block mgr-20">身份证反面</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" id="fan2" name="fan">
                            </div>
                        </div>
                        <div class="mobileDiv relative mgt-30">
                            手机号
                            <input type="text" placeholder="请输入手机号" class="mobile" id="gerenMobile" name="mobile" autocomplete="off">
                        </div>
                        <div class="mgt-30 relative verifyCodeDiv">
                            验证码
                            <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode3" name="verifyCode" autocomplete="off">
                            <!--<button class="verifyBtn">获取验证码</button>-->
                            <button class="teleCodeBtn get-code verifyBtn">获取验证码</button>
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">人脸识别</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" id="renlian2" name="renlian">
                        </div>
                        <div class="nameDiv relative mgt-30">
                            店名
                            <input type="text" placeholder="请输入店名" class="name" id="shopName2" name="shopName" autocomplete="off">
                        </div>
                        <div class="idDiv mgt-30 relative">
                            统一社会信用代码
                            <input type="text" placeholder="请输入统一社会信用代码" class="shehuiDaima" id="shehuiDaima2" name="shehuiDaima" autocomplete="off">
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">个人证件或作品上传</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" id="zuopin" name="zuopin">
                        </div>
                        <div class="xieyiDiv">
                            <input type="checkbox" name="type" value="1" class="type" checked/>
                            <label for="">我已阅读和同意 <a href="">《注册协议》</a></label>
                        </div>
                        <div class="step2Btn">
                            <button class="submit stepBtnActive"
                                    onClick="return false;"
                                    data-stage="personal_info">确定</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!--第三步-->
        <div class="stepPart stepPartLast hidden">
            <!--3.注册完成-->
            <div class="level1 clearfix">
                <div class="mgl-250">
                    <!--注册第三步，第一，二步已隐藏 ，当前样式类名：stepActive 根据步骤替换即可-->
                    <div class="fl step1 stepActive"><p><span>1</span>设置用户名</p></div>
                    <div class="fl step2 stepActive"><p><span>2</span>填写账号信息</p></div>
                    <div class="fl step3 stepActive"><p><span>3</span>注册完成</p></div>
                </div>
            </div>
            <div class="step3Div">
                <form class="cmxform" id="verifyForm3" method="get" action="">
                    <div class="registerOver clearfix">
                        <img src="{{ asset('home/images/img/registerOver.png') }}" alt="" class="mgl-400"/>
                        <div class="registerOverRight">
                            <p class="">注册完成您的用户名：<span>1111</span>，您已成为了本站的正式会员！</p>
                            <p>5秒钟后自动转到首页！</p>
                            <p>马上进入 <a href="">个人中心</a> <a href="">返回网站首页</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('shop')
    @endsection
</div>
@endsection

@section('section')
    <script type="text/javascript">
        var category = 0;
        var info = ['buyer_info', 'enterprise_info', 'personal_info'];
        $('.stepBtnActive').on('click', function () {
            var that = $(this);
            var stage = that.data('stage');
            var btn = $('#'+ stage).serializeArray();
            console.log('验证数据: ' + JSON.stringify(btn));
            console.log('当前提交对象: ' + stage);
            processing(btn, stage);
            if(!$('.layui-layer-msg').length) {
                if(stage == "user_info") {
                    $('.user_info').addClass('hidden');
                    $('.account_info').removeClass('hidden');
                    $('.' + info[category]).removeClass('hidden');
                }
                if($.inArray(stage, info) != -1) {
                    var type = that.parent().prev().children('input').is(':checked');
                    if(!type) {
                        layer.msg('请先阅读注册协议');return false;
                    }
                    var data = goEmpty($('form').serializeArray());
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"POST",
                        url:"{!! route('index.regists.create') !!}",
                        data:data,
                        success:function (res) {
                            if(res.status == 200) {

                            }
                        },
                        error:function (XMLHttpRequest) {
                            //返回提示信息
                            try {
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
            }
        });
        /*数据处理*/
        function processing(data, type) {
            $.each(data, function (k, val) {
                if(type == "user_info") {
                    if(val['value'] == '') {
                        layer.msg(comparison(val['name']));return false;
                    } else {
                        if(val['name'] == 'password') {
                            if(/.*[\u4e00-\u9fa5]+.*$/.test(val['value'])) {
                                layer.msg('不可使用中文作为账户密码!');return false;
                            }
                            if(val['value'].length < 6 || val['value'].length > 12) {
                                layer.msg('密码长度需为6-12个字符');return false;
                            }
                        }
                        if(val['name'] == 'category') {
                            category = val['value'];
                        }
                    }
                } else if (type == "buyer_info") {
                    if(val['value'] == '') {
                        layer.msg(comparison(val['name']));return false;
                    } else {
                        if(val['name'] == 'mobile') {
                            console.log('手机号：'+ isPhoneNo(val['value']));
                            if(!isPhoneNo(val['value'])) {
                                layer.msg('请填写正确的手机号'); return false;
                            }
                        }
                        if(val['name'] == 'id') {
                            console.log('身份证号：'+ isCardNo(val['value']));
                            if(!isCardNo(val['value'])){
                                layer.msg('请填写正确的身份证号'); return false;
                            }
                        }
                    }
                }
            });
        }
        /*监听-账号*/
        $('.account').bind("input propertychange", function() {
            var that = $(this);
            monitor(that, 'account');
        });
        /*监听-姓名*/
        $('.name').bind("input propertychange", function() {
            var that = $(this);
            monitor(that, 'name');
        });
        /*监听-身份证号*/
        $('#id').bind("input propertychange", function() {
            var that = $(this);
            monitor(that, 'id');
        });
        /*监听-身份证号*/
        $('.mobile').bind("input propertychange", function() {
            var that = $(this);
            monitor(that, 'mobile');
        });
        /*监听-提交*/
        function monitor(that, parameter)
        {
            var val = that.val();
            if(!val) {
                return;
            }
            var data = {};
            data[parameter] = val;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.verifivWhetExist') !!}",
                data:data,
                success:function (res) {
                    if(res.status == 200) {
                        $(".stepBtnActive").removeAttr('disabled');
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    $(".stepBtnActive").attr('disabled','disabled');
                    try {
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
        /*验证码*/
        $('.verifyBtn').on('click', function () {
            var that = $(this);
            var mobile = $.trim(that.parent().prev().children().val());
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
        /*数据去null*/
        function goEmpty(data) {
            var notEmpty = [];
            var hash = {};
            $.each(data, function (key, value) {
                if(value['value'] != '') {
                    if(!hash[value['name']]) {
                        notEmpty.push(value);
                        hash[value['name']] = true;
                    }
                }
            });
            return notEmpty;
        }
    </script>
@endsection
