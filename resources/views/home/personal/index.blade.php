@extends('home.public.subject')
@section('title', '阿朗博波-个人商务中心')
@section('css')
@parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
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
                            <a href="{{ route('personal.index') }}"  class="leftNavActive">帐户中心</a>
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
                <p>帐户中心</p>
            </div>
            <div class="shInfoDiv">
                <div class="jine clearfix">
                    <div class="fl mgr-80">
                        <p>冻结信用保证金：<span>{{ Auth::guard('web')->user()->frozen_capital }}</span> 元    </p>
                        <a href="">解冻</a>
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
                                    <th>订单号</th>
                                    <th>操作人</th>
                                    <th>交易日期</th>
                                    <th>交易金额</th>
                                    <th>交易类型</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach($items['alltrade'] as $item)
                                        <tr>
                                            <td>{{ $item->order_id }}</td>
                                            <td> {{ Auth::guard('web')->user()->account }} </td>
                                            <td> {{ $item->trans_at }} </td>
                                            <td> {{ $item->money }} 元 </td>
                                            <td>
                                                @if($item->category == 100 || $item->category == 600)
                                                    {{ $item->category_name }} ({{ $item->trademode_name }})
                                                @else
                                                    {{ $item->category_name }}
                                                @endif
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
                                    <th>提现人</th>
                                    <th>提现日期</th>
                                    <th>提现金额</th>
                                    <th>提现方式</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                @foreach($items['withdraw'] as $item)
                                    <tr>
                                        <td> {{ $item->order_id }} </td>
                                        <td> {{ Auth::guard('web')->user()->account }} </td>
                                        <td> {{ $item->created_at }} </td>
                                        <td> {{ $item->money }}元 </td>
                                        <td> {{ $item->trademode_name }} </td>
                                        <td>
                                            @if($item->status == 1001)
                                                成功
                                            @else
                                                失败
                                            @endif
                                        </td>
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
                                    <th>充值对象</th>
                                    <th>充值日期</th>
                                    <th>充值金额</th>
                                    <th>充值方式</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                @foreach($items['recharge'] as $item)
                                    <tr>
                                        <td> {{ $item->order_id }} </td>
                                        <td> {{ Auth::guard('web')->user()->account }} </td>
                                        <td> {{ $item->created_at }} </td>
                                        <td> {{ $item->money }}元 </td>
                                        <td> {{ $item->trademode_name }} </td>
                                        <td>
                                            @if($item->status == 1001)
                                                成功
                                            @else
                                                失败
                                            @endif
                                        </td>
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
                area: ['380px', 'auto'],
                content: '<div class="tab-pane fade in active" id="receiveAddress">\n' +
                    '                            <form class="cmxform" id="receiveForm">\n' +
                    '                                <fieldset class="fieldset clearfix">\n' +
                    '                                    <div class="receiveNameDiv mgt-20" style="text-align:left">\n' +
                    '                                        <span class="receiveStar">*</span>提现方式：\n' +
                    '                                        <div  class="distpicker inline-block">\n' +
                    '                                            <div class="inline-block receiveFormaddress">\n' +
                    '                                                <select name="method">\n' +
                    '                                                    <option value="Alipay">支付宝</option>\n' +
                    '                                                    <option value="WeChat">微信</option>\n' +
                    '                                                </select>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="receiveNameDiv mgt-20" style="text-align:left">\n' +
                    '                                        <span class="receiveStar">*</span>提现金额：\n' +
                    '                                        <input type="text" class="mobile" name="money" autocomplete="off">\n' +
                    '                                    </div><div class="receiveNameDiv mgt-20" style="text-align:left">' +
                    '                                           <span class="receiveStar">*</span>提现账户：' +
                    '                                           <input type="text" class="mobile" name="money" autocomplete="off">' +
                '                                        </div>' +
                    '                                    <button type="submit" class="addressSave recharge" onclick="return false">充值</button>\n' +
                    '                                </fieldset>\n' +
                    '                            </form></div>'
            });
        });
    </script>
@endsection
@endsection

