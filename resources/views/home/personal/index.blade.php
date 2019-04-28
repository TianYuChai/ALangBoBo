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
                    <p>商户中心</p>
                    <ul>
                        @include('home.personal.head_portrait')
                        <li>
                            <a href="{{ route('personal.merchant_data') }}">用户资料</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.index') }}"  class="leftNavActive">帐户中心</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_address.html">收/发货地址</a>
                        </li>
                        <li>
                            <a href="../html/shopCarList-sum.html">我的购物车</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="">信用保证金</a>
                        </li>
                        <li>
                            <a href="">商家入驻费</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_cancelAccount.html">商户注销帐户</a>
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
        <div class="fl mgt-30 rightWidth">
            <div class="shInfoTittle">
                <p>帐户中心</p>
            </div>
            <div class="shInfoDiv">
                <div class="jine clearfix">
                    <div class="fl mgr-80">
                        <p>冻结信用保证金：<span>500.00</span> 元    </p>
                        <a href="">解冻</a>
                    </div>
                    <div class="fl">
                        <p>帐户可用余额：<span>0.00</span> 元</p>
                        <a href="">解冻</a>
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
                            <a href="#withdraw" data-toggle="tab">提现</a>
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
                                    <th>商户店铺</th>
                                    <th>交易日期</th>
                                    <th>交易金额</th>
                                    <th>交易方式</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--tab2 提现-->
                        <div class="tab-pane fade in" id="withdraw">
                            <table align="center" class="table" frame="box" border="1">
                                <thead class="thead">
                                <tr>
                                    <th>订单号</th>
                                    <th>商户店铺</th>
                                    <th>交易日期</th>
                                    <th>交易金额</th>
                                    <th>交易方式</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--tab3 充值-->
                        <div class="tab-pane fade in" id="recharge">
                            <table align="center" class="table" frame="box" border="1">
                                <thead class="thead">
                                <tr>
                                    <th>订单号</th>
                                    <th>商户店铺</th>
                                    <th>交易日期</th>
                                    <th>交易金额</th>
                                    <th>交易方式</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr><tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                <tr>
                                    <td>282000717334027218</td>
                                    <td> 包大圣 </td>
                                    <td> 2019.1.25 15:30:25 </td>
                                    <td> 500元 </td>
                                    <td> 网银付款 </td>
                                    <td> 实缴 </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
