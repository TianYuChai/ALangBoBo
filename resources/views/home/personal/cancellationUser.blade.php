@extends('home.public.subject')
@section('title', '阿朗博波-个人商务中心')
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
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <!--内容区-->
    <div class="container clearfix">
        <!--左边菜单栏-->
        <div class="fl mgt-30">
            <ul class="shLeftNav">
                <li class="firstLevel">
                    <p>{{ Auth::guard('web')->user()->category !=0 ? "商户":"个人" }}中心</p>
                    <ul>
                        @include('home.personal.head_portrait')
                        <li>
                            <a href="{{ route('personal.merchant_data') }}">商户资料</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.index') }}">帐户中心</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.address') }}">地址管理</a>
                        </li>
                        <li>
                            <a href="../html/shopCarList-sum.html">我的购物车</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.creditmargin') }}">信用保证金</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.businresidfee') }}">商家入驻费</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.cancellationuser') }}" class="leftNavActive">注销帐户</a>
                        </li>
                    </ul>
                </li>
                <li class="firstLevel">
                    <p>店铺管理</p>
                    <ul>
                        <li>
                            <a href="../html/shopManage_shopSign.html">店招更换</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_navMenu.html">导航菜单栏</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_bannerList.html">店铺轮播</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_productManage.html">商品管理</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">订单管理</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_accountCenter.html">账务中心</a>
                        </li>
                    </ul>
                </li>
                <li class="firstLevel">
                    <p>分享推广</p>
                    <ul>
                        <li>
                            <a href="">生成链接</a>
                        </li>
                        <li>
                            <a href="">推广统计</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--右边内容区-->
        <div class="fl mgt-30">
            <div class="shInfoTittle">
                <p>注销账号</p>
            </div>
            <div class="shInfoDiv pdl-260">
                <form class="cancelAccountForm" id="shInfoForm">
                    <fieldset>
                        <div class="cancelMobileDiv tr mgt-20">
                            手机号：
                            <input type="text"
                                   class="cancelMobile"
                                   id="cancelMobile"
                                   name="cancelMobile"
                                   value="{{ Auth::guard('web')->user()->number }}" readonly>
                        </div>
                        <div class="mgt-30 relative verifyCodeDiv mgt-20 tr">
                            验证码：
                            <input type="text" placeholder="验证码" class="verifyCode" id="verifyCode" name="verifyCode" autocomplete="off">
                            <!--<button class="verifyBtn">获取验证码</button>-->
                            <button class="teleCodeBtn get-code verifyBtn" onclick="return false;">获取验证码</button>
                        </div>
                        {{--<div class="cencelReasonDiv mgt-20">--}}
                            {{--<p class="inline-block">注销原因：</p>--}}
                            {{--<div class="inline-block">--}}
                                {{--<input type="radio" name="cancelReason"/>我有多个账号 <br/>--}}
                                {{--<input type="radio" name="cancelReason"/>我想重新开店 <br/>--}}
                                {{--<input type="radio" name="cancelReason"/>该账户不是我的 <br/>--}}
                                {{--<input type="radio" name="cancelReason"/>其他 <br/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="border-bottom"></div>
                        <button class="shInfoSave" type="submit" onclick="return false;">确定</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
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
                if(val['name'] == 'verifyCode' && (val['value'].length < 6 || val['value'].length >6)) {
                    layer.msg('验证码错误, 请填写正确的验证码'); return false;
                }
                obj[val['name']] = val['value'];
            });
            if(!$('.layui-layer-msg').length) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{{ route("personal.cancellhandleuser") }}",
                    data:obj,
                    success:function (res) {
                        if(res.status == 200) {
                            layer.msg(res.info);
                            setTimeout(function () {
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
            var mobile = $.trim($('#cancelMobile').val());
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
                    return;
                } else if(s < 0){
                    countDown(m-1, 59);
                }
            }, 1000);
        }
    </script>
@endsection
