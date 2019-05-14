@extends('home.public.subject')
@section('title', '阿朗博波-信用保证金')
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
                    <p>{{ Auth::guard('web')->user()->category !=0 ? "商户":"个人" }}中心</p>
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
                            <a href="../html/shopCarList-sum.html">我的购物车</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.creditmargin') }}" class="leftNavActive">信用保证金</a>
                        </li>
                        <li>
                            <a href="">商家入驻费</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.cancellationuser') }}">注销帐户</a>
                        </li>
                    </ul>
                </li>
                <li class="firstLevel">
                    <p>店铺管理</p>
                    <ul>
                        <li>
                            <a href="{{ route('personal.shop.index') }}">店招更换</a>
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
        <div class="fl mgt-30 rightWidth">
            <div class="shInfoTittle">
                <p>信用保证金</p>
            </div>
            <div class="shInfoDiv">
                <div class="receiveSend">
                    <div id="myTabContent" class="tab-content">
                        <!--tab1 收货地址-->
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
                                        <span class="receiveStar">*</span>充值金额：
                                        <input type="text" class="mobile" name="money" autocomplete="off">
                                    </div>
                                    <button type="submit" class="addressSave recharge" onclick="return false">充值</button>
                                </fieldset>
                            </form>
                            <div class="receiveAddressList">
                                <div class="saveAddressTip">
                                    <p>
                                        @foreach($data['group_message'] as $datum)
                                            @if($datum->status != 1002)
                                                <span>{{ $datum->status_name }}金额 : </span>
                                                <span>{{ $datum->price }}元</span>
                                            @endif
                                        @endforeach
                                    </p>
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
                                                <td>{{ $item->status_name }}</td>
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
                if(val['name'] == 'money') {
                    if(!val['value']) {
                        layer.msg('请填入充值金额');
                    }
                    if(!$('.layui-layer-msg').length) {
                        if(val['value'] < 100) {
                            layer.msg('充值金额需大于100元');
                        }
                    }
                }
                obj[val['name']] = val['value'];
            });
            if(!$('.layui-layer-msg').length) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{{ route("personal.pay") }}",
                    data:obj,
                    dateType:'html',
                    success:function (res) {
                        $('body').append(res);
                        $("form").attr("target", "_blank");
                        // if(res.status == 200) {
                        //     layer.msg(res.info);
                        //     setTimeout(function () {
                        //         window.location.reload();
                        //     }, 300)
                        // }
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
