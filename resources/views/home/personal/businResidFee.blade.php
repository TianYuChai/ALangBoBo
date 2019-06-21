@extends('home.public.subject')
@section('title', '阿朗博波-商家入驻费')
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
                            <a href="{{ route('personal.index') }}">帐户中心</a>
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
                        <li>
                            <a href="{{ route('personal.businresidfee') }}" class="leftNavActive">商家入驻费</a>
                        </li>
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
                <p>商家入驻费</p>
            </div>
            <div class="shInfoDiv">
                <div class="receiveSend">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="receiveAddress">
                            <form class="cmxform" id="receiveForm">
                                <fieldset class="fieldset clearfix">
                                    <div class="receiveNameDiv mgt-20" style="text-align:left">
                                        <span class="receiveStar">*</span>充值方式：
                                        <div  class="distpicker inline-block">
                                            <div class="inline-block receiveFormaddress">
                                                <select name="method">
                                                    <option value="Alipay">支付宝</option>
                                                    <option value="WeChat">微信</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="receiveNameDiv mgt-20" style="text-align:left">
                                        <span class="receiveStar">*</span>充值选择：
                                        <div  class="distpicker inline-block">
                                            <div class="inline-block receiveFormaddress">
                                                <select name="recharge">
                                                    @foreach($data['recharge_options'] as $option)
                                                        <option value="{{ $option->id }}">{{ $option->name .'----'. $option->moneys }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="addressSave recharge" onclick="return false">充值</button>
                                </fieldset>
                            </form>
                            <div class="receiveAddressList">
                                <div class="saveAddressTip">
                                </div>
                                <table align="center" class="table tl" frame="box" border="1">
                                    <thead class="thead">
                                    <tr>
                                        <th>订单号</th>
                                        <th>充值日期</th>
                                        <th>金额</th>
                                        <th>充值方式</th>
                                        <th>状态</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody tl">
                                    @foreach($data['items'] as $item)
                                        <tr>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->money }}</td>
                                            <td>{{ $item->trade_mode }}</td>
                                            <td>{{ $item->status == 1002 ? "未支付" : "已支付" }}</td>
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
    </div>
@section('shop')
@endsection
@section('section')
    <script type="text/javascript">
        $('.recharge').click(function () {
            var obj = {};
            var message = $('#receiveForm').serializeArray();
            $.each(message, function (k, val) {
                obj[val['name']] = val['value'];
            });
            if(!$('.layui-layer-msg').length) {
                let pay_method = obj['method'];
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{{ route("personal.businresidfee.pay") }}",
                    data:obj,
                    dateType:'html',
                    success:function (res) {
                        if(pay_method == 'WeChat') {
                            layer.open({
                                type: 1,
                                closeBtn: false,
                                title: '微信支付',
                                skin: 'layui-layer-rim', //加上边框
                                area: ['420px', '300px'], //宽高
                                btn: ['完成'],
                                btnAlign: 'c',
                                content: '<svg class="ewmImg" ' +
                                    'style="width: 200px;margin: 20px auto;display: block;" src="'+ res +'"></svg>',
                                yes:function(index){
                                    layer.close(index);
                                    window.location.reload();
                                }

                            })
                        } else {
                            $('body').append(res);
                            $("form").attr("target", "_blank");
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
    </script>
@endsection
@endsection

