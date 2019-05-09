@extends('home.public.subject')
@section('title', '阿朗博波-忘记密码')
@section('css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
<script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
<link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
<link rel="stylesheet" href="{{ asset('home/css/shopManage_cancelAccount.css') }}"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/distpicker/2.0.3/distpicker.js"></script>
@endsection
@section('content')
@section('header')
@endsection
<!--内容区-->
<div>
    <!--右边内容区-->
    <div>
        <div>
            <form class="cancelAccountForm" id="shInfoForm" style="margin: auto">
                <fieldset>
                    <div class="cancelMobileDiv tr mgt-20">
                        手机号：
                        <input type="text"
                               class="cancelMobile"
                               name="mobile"
                               value="">
                    </div>
                    <div class="cancelMobileDiv tr mgt-20">
                        新密码：
                        <input type="password"
                               class="cancelMobile"
                               name="password"
                               value="">
                    </div>
                    <div class="mgt-30 relative verifyCodeDiv mgt-20 tr">
                        验证码：
                        <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode" name="verifyCode" autocomplete="off">
                        <button class="teleCodeBtn get-code verifyBtn" onclick="return false;">获取验证码</button>
                    </div>
                    <div class="border-bottom"></div>
                    <button class="shInfoSave" type="submit" onclick="return false;">确定</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@section('bottom')
@endsection
@endsection
@section('shop')
@endsection
@section('section')
<script type="text/javascript">
    $('.shInfoSave').click(function () {
        var obj = {};
        $.each($('#shInfoForm').serializeArray(), function (k, val) {
            if(val['value'] == '') {
                layer.msg('请填写验证码'); return false;
            }
            if(val['name'] == 'verifyCode' && val['value'].length != 6) {
                layer.msg('验证码错误, 请填写正确的验证码'); return false;
            }
            if(val['name'] == "password" && (val['value'].length < 6 || val['value'].length > 12)) {
                layer.msg('密码格式不正确'); return false;
            }
            obj[val['name']] = val['value'];
        });
        if(!$('.layui-layer-msg').length) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{{ route("index.login.handleforgetpass") }}",
                data:obj,
                success:function (res) {
                if(res.status == 200) {
                    layer.msg(res.info);
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                        parent.layer.close(index);
                        window.location.reload();
                    }, 300)
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                //返回提示信息
                try {
                    if(XMLHttpRequest.status == 401) {
                        var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                        layer.msg(errors[0]);return;
                    }
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
    });
    $('.verifyBtn').on('click', function () {
        var that = $(this);
        var mobile = $.trim($('input[name=mobile]').val());
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
            if(m == 0 && s < 0) {
                clearInterval(time);
                $('.verifyBtn').text('获取验证码');
                $('.verifyBtn').removeAttr('disabled');
                return false;
            } else if(s < 0){
                countDown(m-1, 59);
            }
        }, 1000);
    }
</script>
@endsection
