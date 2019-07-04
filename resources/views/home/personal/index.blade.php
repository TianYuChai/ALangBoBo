@extends('home.public.subject')
@section('title', '阿朗博波-个人商务中心')
@section('css')
@parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_address.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_accountCenter.css') }}"/>
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
                    <p>{{ Auth::guard('web')->user()->whermerchant ? "商户":"个人" }}中心</p>
                    <ul>
                        @include('home.personal.head_portrait')
                        <li>
                            <a href="{{ route('personal.merchant_data') }}">用户资料</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.index') }}" class="leftNavActive">帐户中心</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.address') }}">地址管理</a>
                        </li>
                        <li>
                            <a href="{{ route('shopp.shopp.car') }}">我的购物车</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.havegoods', ['type' => 'allOrder']) }}">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.sendtime.index') }}">兼职投递记录</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.demand.index') }}">百录倩影</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.creditmargin') }}">信用保证金</a>
                        </li>
                        @include('home.personal.judge_merchange')
                        <li>
                            <a href="{{ route('personal.cancellationuser') }}">注销帐户</a>
                        </li>
                    </ul>
                </li>
                @include('home.personal.merchant_menu')
            </ul>
        </div>
        <!--右边内容区-->
        <div class="fl mgt-30 rightWidth">
            <div class="shInfoTittle">
                <p>帐户中心</p>
            </div>
            <div class="shInfoDiv">
                <div class="jine clearfix">
                    <div class="fl mgr-80">
                        <p>冻结信用保证金：<span>{{ Auth::guard('web')->user()->frozen_capital }}</span> 元    </p>
                        {{--<a href="">解冻</a>--}}
                    </div>
                    <div class="fl">
                        <p>帐户可用余额：<span>{{ Auth::guard('web')->user()->available_money }}</span> 元</p>
                        <a href="javascript:void(0)" class="tixian">提现</a>
                    </div>
                </div>
                <!--列表部分-->
                <div class="pdlr-50">
                    <ul id="myTab" class="nav nav-tabs accountList">
                        <li class="active">
                            <a href="#allTrade" data-toggle="tab">
                                交易记录全部
                            </a>
                        </li>
                        <li>
                            <a href="#withdraw" data-toggle="tab" >提现</a>
                        </li>
                        <li>
                            <a href="#recharge" data-toggle="tab">
                                充值
                            </a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content accountListDiv">
                        <!--tab1 交易记录全部-->
                        <div class="tab-pane fade in active" id="allTrade">
                            <table align="center" class="table" frame="box" border="1">
                                <thead class="thead">
                                <tr>
                                    <th width="185px">订单号</th>
                                    <th>交易日期</th>
                                    <th width="80px">交易金额</th>
                                    <th width="80px">交易类型</th>
                                    <th width="80px">状态</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach($items['alltrade'] as $item)
                                        <tr>
                                            <td width="185px">{{ $item->order_id }}</td>
                                            <td> {{ $item->created_at }} </td>
                                            <td width="80px"> {{ $item->money }} 元 </td>
                                            <td width="80px">
                                                @if($item->category == 100 || $item->category == 600)
                                                    {{ $item->category_name }} ({{ $item->trademode_name }})
                                                @else
                                                    {{ $item->category_name }}
                                                @endif
                                            </td>
                                            <td width="80px">
                                                @if($item->status == 1002)
                                                    交易失败
                                                @else
                                                    {{ $item->status_name }}
                                                @endif
                                            </td>
                                            <td> {{ $item->memo }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--tab2 提现-->
                        <div class="tab-pane fade in" id="withdraw">
                            <table align="center" class="table" frame="box" border="1">
                                <thead class="thead">
                                <tr>
                                    <th>订单号</th>
                                    <th>提现金额</th>
                                    <th>提现方式</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                @foreach($items['withdraw'] as $item)
                                    <tr>
                                        <td> {{ $item->order_id }} </td>
                                        <td> {{ $item->money }}元 </td>
                                        <td> {{ $item->trademode_name }} </td>
                                        <td>
                                            @if($item->status == 1001)
                                                成功
                                            @else
                                                失败
                                            @endif
                                        </td>
                                        <td> {{ $item->memo }} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--tab3 充值-->
                        <div class="tab-pane fade in" id="recharge">
                            <table align="center" class="table" frame="box" border="1">
                                <thead class="thead">
                                <tr>
                                    <th>订单号</th>
                                    <th>充值金额</th>
                                    <th>充值方式</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                @foreach($items['recharge'] as $item)
                                    <tr>
                                        <td> {{ $item->order_id }} </td>
                                        <td> {{ $item->money }}元 </td>
                                        <td> {{ $item->trademode_name }} </td>
                                        <td>
                                            @if($item->status == 1001)
                                                成功
                                            @elseif($item->status == 1003)
                                                冻结
                                            @else
                                                失败
                                            @endif
                                        </td>
                                        <td> {{ $item->memo }} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('shop')
    @endsection
@section('section')
    <script type="text/javascript">
        $('.tixian').click(function () {
            layer.open({
                title:'提现操作',
                type: 1,
                skin: 'layui-layer-demo', //样式类名
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['620px', '415px'],
                content: '<div class="tab-pane fade in active" id="receiveAddress">\n' +
                    '                            <form class="cmxform" id="receiveForm">\n' +
                    '                                <fieldset class="fieldset clearfix">\n' +
                    '                                    <div class="receiveNameDiv mgt-20" style="text-align:left">\n' +
                    '                                        <span class="receiveStar">*</span>提现方式：\n' +
                    '                                        <div  class="distpicker inline-block">\n' +
                    '                                            <div class="inline-block receiveFormaddress">\n' +
                    '                                                <select name="method">\n' +
                    '                                                    <option value="Alipay">支付宝</option>\n' +
                    '                                                </select>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="receiveNameDiv mgt-20" style="text-align:left">\n' +
                    '                                        <span class="receiveStar">*</span>提现金额：\n' +
                    '                                        <input type="text" class="mobile" name="money" autocomplete="off" style="width: 240px">\n' +
                    '                                    </div>' +
                    '                                       <div class="receiveNameDiv mgt-20" style="text-align:left">' +
                    '                                           <span class="receiveStar">*</span>提现账户：' +
                    '                                           <input type="text" class="mobile" name="account" autocomplete="off" style="width: 240px">' +
                    '                                    </div> <div class="receiveNameDiv mgt-20" style="text-align:left">' +
                    '                                                             <span class="receiveStar"></span>' +
                    '                                                               <span style="color: red">请填入正确提现账号</span>' +
                    '                                                       </div>' +
                    '                                    <div class="receiveNameDiv mgt-20" style="text-align:left">' +
                    '                                    <span class="receiveStar">*</span>手机号：<span style="color: red">验证码会发送到绑定的手机上请注意查收</span></div>' +
                    '                                    <div class="receiveNameDiv mgt-20" style="text-align:left">' +
                    '                                   <span class="receiveStar">*</span>验证码：' +
                    '                                   <input type="text" placeholder="验证码" class="verifyCode" style="width: 240px" id="verifyCode" name="code" autocomplete="off">' +
                    '                                   <button class="teleCodeBtn get-code verifyBtn" onclick="return false;">获取验证码</button>' +
                    '                                   </div>' +
                    '                                    <button type="submit" class="addressSave recharge" onclick="return false">确认提现</button>\n' +
                    '                                </fieldset>\n' +
                    '                            </form></div>'
            });
        });
        $('body').on('click','.recharge', function () {
            var obj = {};
            var data = $('#receiveForm').serializeArray();
            var money = "{!! Auth::guard('web')->user()->available_money !!}";
            $.each(data, function (k, val) {
                if(!val['value']) {
                    var tip = val['name'] == 'money' ? "请输入提现金额" : val['name'] == 'account' ? "请输入提现账户":"请填入验证码";
                    layer.msg(tip);return false;
                }
                if(val['name'] == 'money') {
                    if(isNaN(val['value'])) {
                        layer.msg('请输入正确金额'); return false;
                    }
                    if(val['value'] < 100) {
                        layer.msg('提现金额需大于100元'); return false;
                    }
                    if(val['value'] > money) {
                        layer.msg('大于可提现金额'); return false;
                    }
                }
                if(val['name'] == 'code' && (val['value'].length < 6 || val['value'].length > 6)) {
                    layer.msg('验证码错误'); return false;
                }
                obj[val['name']] = val['value'];
            });
            if(!$('.layui-layer-msg').length) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{{ route("personal.cashWithdrawal") }}",
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
        $('body').on('click', '.verifyBtn', function () {
            var that = $(this);
            var mobile = "{!! Auth::guard('web')->user()->number !!}";
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
@endsection

