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
                            <span style="color: red">
                                提示：注册企业商户和个人商户需进行人脸识别, 请使用火狐浏览器进行识别.
                                <a href="https://download-ssl.firefox.com.cn/releases-sha2/stub/official/zh-CN/Firefox-latest.exe">
                                    点我下载
                                </a>
                            </span>
                        </div>
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
                            <label for="">我已阅读和同意 <a href="javascript:void(0)" class="agreement" data-type="user">《注册协议》</a></label>
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
            <div class="step2Div  hidden enterprise_info">
                <form class="cmxform" id="enterprise_info">
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
                                <input type="file" class="file" accept="image/*" data-id="zheng">
                                <input type="hidden" name="zheng">
                            </div>
                            <div class="relative">
                                <p class="inline-block mgr-20">身份证反面</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" accept="image/*" data-id="fan">
                                <input type="hidden" name="fan">
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
                            <button class="teleCodeBtn get-code verifyBtn" onClick="return false;">获取验证码</button>
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">人脸识别</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg face" id="face"/>
                            {{--<input type="file" class="file" id="renlian" name="renlian">--}}
                        </div>
                        <div class="nameDiv relative mgt-30">
                            店名
                            <input type="text" placeholder="请输入店名" class="shopName" id="shopName" name="shopName" autocomplete="off">
                        </div>
                        <div class="idDiv mgt-30 relative">
                            统一社会信用代码
                            <input type="text" placeholder="请输入统一社会信用代码" class="shehuiDaima" id="shehuiDaima" name="shehuiDaima" autocomplete="off">
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">营业执照上传</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" data-id="yyzz" accept="image/*">
                            <input type="hidden" name="yyzz">
                        </div>
                        <div class="idImgDiv mgt-30 relative">
                            <div class="relative">
                                <p class="inline-block">食品行业证件上传</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" data-id="food" accept="image/*">
                                <input type="hidden" name="food">
                            </div>
                            <div class="relative">
                                <p class="inline-block">美容或理发行业</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" data-id="mrlf" accept="image/*">
                                <input type="hidden" name="mrlf">
                            </div>
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block">其它行业证件上传</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" data-id="qt" accept="image/*">
                            <input type="hidden" name="qt">
                        </div>
                        <div class="xieyiDiv">
                            <input type="checkbox" name="type" value="1" class="type" checked/>
                            <label for="">我已阅读和同意 <a href="javascript:void(0)" class="agreement" data-type="business">《注册协议》</a></label>
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
                <form class="cmxform" id="personal_info">
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
                                <input type="file" class="file" accept="image/*" data-id="zheng">
                                <input type="hidden" name="zheng">
                            </div>
                            <div class="relative">
                                <p class="inline-block mgr-20">身份证反面</p>
                                <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                                <input type="file" class="file" accept="image/*" data-id="fan">
                                <input type="hidden" name="fan">
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
                            <button class="teleCodeBtn get-code verifyBtn" onClick="return false;">获取验证码</button>
                        </div>
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">人脸识别</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg face" id="face"/>
                            {{--<input type="file" class="file" id="renlian2" name="renlian">--}}
                        </div>
                        <div class="nameDiv relative mgt-30">
                            店名
                            <input type="text" placeholder="请输入店名" class="shopName" id="shopName2" name="shopName" autocomplete="off">
                        </div>
                        {{--<div class="idDiv mgt-30 relative">--}}
                            {{--统一社会信用代码--}}
                            {{--<input type="text" placeholder="请输入统一社会信用代码" class="shehuiDaima" id="shehuiDaima2" name="shehuiDaima" autocomplete="off">--}}
                        {{--</div>--}}
                        <div class="idImgDiv mgt-30 relative faceCheckDiv">
                            <p class="inline-block mgr-20">个人证件或作品上传</p>
                            <img src="{{ asset('home/images/img/idImg.png') }}" alt="" class="personalImg"/>
                            <input type="file" class="file" data-id="zuopin" accept="image/*">
                            <input type="hidden" name="zuopin">
                        </div>
                        <div class="xieyiDiv">
                            <input type="checkbox" name="type" value="1" class="type" checked/>
                            <label for="">我已阅读和同意 <a href="javascript:void(0)" class="agreement" data-type="business">《注册协议》</a></label>
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
                        <div class="registerOverRight"></div>
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
        var whether = false;
        var info = ['buyer_info', 'enterprise_info', 'personal_info'];
        var img_name = ['food', 'mrlf', 'qt'];
        $('.stepBtnActive').on('click', function () {
            var that = $(this);
            var stage = that.data('stage');
            var btn = $('#'+ stage).serializeArray();
            console.log('验证数据: ' + JSON.stringify(btn));
            console.log('当前提交对象: ' + stage);
            processing(btn, stage);
            if(!$('.layui-layer-msg').length) {
                console.log('人脸识别1: ' + whether);
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
                    if(stage != 'buyer_info') {
                        console.log('人脸识别3: ' + whether);
                        if(!whether) {
                            layer.msg('请先进行人脸识别');return false;
                        }
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
                                var htm = '';
                                $('.' + stage).addClass('hidden');
                                $('.account_info').addClass('hidden');
                                $('.stepPartLast').removeClass('hidden');
                                if(res.data['category'] == 0) {
                                    htm = '<p>注册完成! 您的用户名：</p><span>'+res.data['account']+'</span>，您已成为了本站的正式会员！' +
                                        '<p><span class="down">5</span>秒钟后自动跳转到首页！</p><p>马上进入 <a href="">个人中心</a> <a href="">返回网站首页</a></p>'
                                } else {
                                    htm = '<p>注册完成, 请耐心等待审核！审核周期：1-2小时, 之后请通过登陆查询审核结果。</p><p><span class="down">5</span>秒钟后自动跳转到首页！</p>';
                                }
                                $('.registerOverRight').append(htm);
                                down();
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
                                var errors = JSON.parse(XMLHttpRequest.responseText)['errors'];
                                for (var value in errors) {
                                    layer.msg(errors[value][0]);return;
                                }
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
                            if(!/([a-zA-Z]+[0-9]+|[0-9]+[a-zA-Z])/.test(val['value'])) {
                                layer.msg('密码安全程度过低');return false;
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
                } else {
                    if($.inArray(val['name'], img_name) == -1) {
                        if(val['value'] == '') {
                            layer.msg(comparison(val['name']));return false;
                        }
                    }
                }
            });
        }
        /*监听-账号*/
        $('.account').blur(function() {
            var that = $(this);
            monitor(that, 'account');
        });
        /*监听-姓名*/
        $('.name').blur(function() {
            var that = $(this);
            monitor(that, 'name');
        });
        /*监听-身份证号*/
        $('input[name="id"]').blur(function() {
            var that = $(this);
            monitor(that, 'id');
        });
        /*监听-营业执照*/
        $('input[name="shehuiDaima"]').blur(function () {
            var that = $(this);
            monitor(that, 'shehuiDaima');
        });
        /*监听-号码*/
        // .bind("input propertychange",
        $('.mobile').blur(function() {
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
            data['category'] = category;
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
        /*图片-上传*/
        $("input[type='file']").on('change', function () {
            var that = $(this);
            var file = that[0].files[0];
            var image = $('input[name='+that.data('id')+']');
            var image_path = image.val();
            that.prev().attr('src', URL.createObjectURL(file)).css({"width":"117px","height":"101px"});
            var formData = new FormData();
            formData.append('file', file);
            formData.append('image_path', image_path);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route("file.upload") !!}",
                processData: false,
                contentType: false,
                data:formData,
                success:function (res) {
                    if(res.status == 200) {
                        image.val(res.url[0]);
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
                if(m == 0 && s < 0) {
                    clearInterval(time);
                    $('.verifyBtn').text('获取验证码');
                    $('.verifyBtn').removeAttr('disabled');
                    return;
                } else if(s < 0){
                    countDown(m-1, 59);
                }
            }, 1000);
        }
        function down() {
            var s = 5;
            var time = setInterval(function(){
                $('.down').text(s);
                s--;
                if(s < 0) {
                    clearInterval(time);
                    window.location.href = "{{ url('/') }}";
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
        /*调用摄像头*/
        $('.face').click(function () {
            var that = $(this);
            if($('input[name="zheng"]').val() == '') {
                layer.msg('请先上传身份证');return false;
            }
            var constraints = {
                video: {width: 500, height: 500},
                audio: false
            };
            if (navigator.mediaDevices === undefined) {
                navigator.mediaDevices = {};
            }
            if (navigator.mediaDevices.getUserMedia === undefined) {
                navigator.mediaDevices.getUserMedia = function(constraints) {
                    // 首先，如果有getUserMedia的话，就获得它
                    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                    // 一些浏览器根本没实现它 - 那么就返回一个error到promise的reject来保持一个统一的接口
                    if (!getUserMedia) {
                        return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                    }
                    // 否则，为老的navigator.getUserMedia方法包裹一个Promise
                    return new Promise(function(resolve, reject) {
                        getUserMedia.call(navigator, constraints, resolve, reject);
                    });
                }
            }
            //获得video摄像头区域
            // var promise = navigator.mediaDevices.getUserMedia(constraints);
            //获得video摄像头区域
            if(navigator.mediaDevices.getUserMedia){
                //最新标准API
                var promise = navigator.mediaDevices.getUserMedia(constraints);
            } else if (navigator.webkitGetUserMedia){
                //webkit内核浏览器
                var promise = navigator.webkitGetUserMedia(constraints);
            } else if (navigator.mozGetUserMedia){
                //Firefox浏览器
                var promise = navagator.mozGetUserMedia(constraints);
            } else if (navigator.getUserMedia){
                //旧版API
                var promise = navigator.getUserMedia(constraints);
            }
            promise.then(function (MediaStream) {
                layer.alert('请对准摄像头, 五秒后自动拍照', {icon: 6}, function (index) {
                    layer.close(index);
                    that.hide();
                    that.after('<video id="video" width="500" height="300" autoplay></video>' +
                        '<canvas id="canvas" width="450" height="250"></canvas>');
                    var video = document.getElementById("video");
                    // 旧的浏览器可能没有srcObject
                    if ("srcObject" in video) {
                        video.srcObject = MediaStream;
                    } else {
                        // 防止在新的浏览器里使用它，它已经不再支持了
                        video.src = window.URL.createObjectURL(MediaStream);
                    }
                    video.onloadedmetadata = function(e) {
                        video.play();
                    };
                    // video.srcObject = MediaStream;
                    // video.play();
                    setTimeout(function () {
                        takePhoto();
                    }, 5000)
                });
            }).catch((err)=>{
                layer.msg(err.name + ': 系统未监测到您的摄像设备, 请先安装摄像设备');
            });
        });
        function takePhoto() {
            //获得Canvas对象
            var video = document.getElementById("video");
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, 500, 250);
            $("#video").hide();
            //处理canvas图片
            // var face_img = canvas.toDataURL().substring(canvas.toDataURL().indexOf(",")+ 1);
            var face_img = dataURLtoFile(canvas.toDataURL('image/png'));
            console.log(face_img);
            var formData = new FormData();
            formData.append('face_img', face_img);
            formData.append('crid_img', $('input[name="zheng"]').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route("index.face") !!}",
                processData: false,
                contentType: false,
                data:formData,
                success:function (res) {
                    if(res.status == 200) {
                        whether = res.info;
                        console.log('人脸识别2: ' + whether);
                        if(!whether) {
                            $('.face').show();
                            $('#canvas').hide();
                            layer.msg('人脸识别失败, 请进行重新识别！');return false;
                        }
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
        //base64转换成file对象
        function dataURLtoFile(dataurl, filename = 'file') {
            var arr = dataurl.split(',');
            var mime = arr[0].match(/:(.*?);/)[1];
            var bstr = atob(arr[1]);
            var n = bstr.length;
            var u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            //转换成file对象
            return new File([u8arr], filename, {type:mime});
            //转换成成blob对象
            //return new Blob([u8arr],{type:mime});
        }
        //注册协议
        $('.agreement').click(function () {
            var type = $(this).data('type');
            layer.open({
                type: 1,
                title:type == 'user' ? '用户协议' : '商家入驻协议',
                time:30000,
                skin: 'layui-layer-rim', //加上边框
                area: ['75%', '100%'], //宽高
                content: type == 'user' ? user : business
            });
        })
    </script>
@endsection
