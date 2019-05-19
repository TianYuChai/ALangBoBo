@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-店招更换')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_shopSign.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_navMenu.css') }}"/>
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
                        @include('home.personal.judge_merchange')
                        <li>
                            <a href="{{ route('personal.cancellationuser') }}">注销帐户</a>
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
                            <a href="../html/shopManage_navMenu.html" class="leftNavActive">导航菜单栏</a>
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
                <p>导航菜单栏</p>
            </div>
            <div class="shInfoDiv">
                <a href="" class="changeSignBtn" data-toggle="modal" data-target="#addNavMenu">
                    <img src="{{ asset('home/images/icon/changeIcon.png') }}" alt=""/>
                    添加分类
                </a>
                <div class="changeSignTable">
                    <table align="center" class="table" frame="box">
                        <thead class="thead">
                        <tr>
                            <th width="110">分类名称</th>
                            <th>创建时间</th>
                            <th>分类类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbody tc">
                        <tr>
                            <td class="tc">

                            </td>
                            <td>2019-03-17</td>
                            <td>商家分类</td>
                            <td>
                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="mgr-10">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="addNavMenu" tabindex="-1" role="dialog" aria-labelledby="addNavMenu" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title">
                                    <p class="changeContentTip"><img src="../images/icon/changeContentIcon.png" alt=""/>添加分类</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent navMenuModal">
                                    <table align="center" class="table" frame="box">
                                        <thead class="thead">
                                        <tr>
                                            <th width="110">分类名称</th>
                                            <th>默认展开</th>
                                            <th>创建时间</th>
                                            <th>分类类型</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody tc">
                                        <tr>
                                            <td class="tc">
                                                <select name="" class="navProductSelect">
                                                    <option value="">所有产品</option>
                                                    <option value="">子产品</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="radio" name="showHidden"/>
                                                <label>是</label>
                                                <input type="radio" name="showHidden"/>
                                                <label>否</label>
                                            </td>
                                            <td>2019-03-17</td>
                                            <td>手动分类</td>
                                            <td>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="mgr-10">删除</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary">
                                    保存
                                </button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
    <script type="text/javascript">
        function deleteTr(nowTr){
            //多一个parent就代表向前一个标签,
            // 本删除范围为<td><tr>两个标签,即向前两个parent
            //如果多一个parent就会删除整个table
            $(nowTr).parent().parent().remove();
            $(this).closest('tr').remove();  //清空当前行
        };
    </script>
@endsection