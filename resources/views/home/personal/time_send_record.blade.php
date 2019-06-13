@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-兼职管理')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/common/base.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/common/normalize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_buyThings.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_productManage.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/distpicker/2.0.3/distpicker.js"></script>
    <style type="text/css">
        input[type='file']{
            width: 117px;
            height: 102px;
            position: absolute;
            top: 0;
            font-size:0;
            cursor: pointer;
            opacity: 0;
        }
        .display_img{
            float:left;
            position:relative;
            margin-right:30px
        }
        .del{
            position:absolute;
            top:-9px;
            left:110px;
            cursor:pointer;
        }
    </style>
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
                        <a href="{{ route('personal.sendtime.index') }}" class="leftNavActive">兼职投递记录</a>
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
    <div class="fl mgt-30">
        <div class="shInfoDiv shopCarContent">
            <!--列表部分-->
            <div class="receiveSend">
                <ul id="myTab" class="nav nav-tabs shopCarList">
                    <li class="active">
                        <a href="#productList" data-toggle="tab">
                            兼职列表
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <!--tab1 商品列表-->
                    <div class="tab-pane fade in active" id="productList">
                        <div class="productListTop clearfix">
                            <p><img src="{{ asset('home/images/icon/productList.png') }}" alt=""/>兼职列表</p>
                        </div>
                        <form action="" method="get" id="subForm">
                            <div class="orderSearch clearfix">
                                <input type="text" placeholder="输入兼职名称" name="title" value="{{ Input::get('title', '') }}"/>
                                <a onclick="document:subForm.submit()">查询</a>
                            </div>
                        </form>
                        <div class="orderList">
                            <table align="center" class="table tl" frame="box">
                                <thead class="thead" style="border:1px solid #e8e8e8;background-color: #ebecf0;">
                                <tr>
                                    <th class="tl" width="200">兼职名称</th>
                                    <th class="tl" width="90">投递时间</th>
                                    <th class="tl" width="90">操作</th>
                                </tr>
                                </thead>
                                <tbody class="listTbody">
                                @foreach($items as $item)
                                    <tr>
                                        <td>
                                            <p class="fl productName">
                                                <a href="{{ route('partime.show', ['id' => $item->pid]) }}" target="_blank">
                                                    {{ $item->part->title }}
                                                </a>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="fl productName">{{ $item->created_at }}</p>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="block mgt-10 dele"
                                               data-action="{{ route('personal.sendtime.del', ['id' => $item->id]) }}">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: right;">
                                {!! $items->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('shop')
@endsection
@section('js')
@parent
<script src="{{ asset('home/js/public.js') }}"></script>
<script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection
@section('section')
    <script type="text/javascript">
        $('.dele').click(function () {
            let url = $(this).data('action');
            layer.confirm('是否进行该操作？', {
                btn: ['是','否'] //按钮
            },  function(index) {
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"GET",
                    url:url,
                    success:function (res) {
                        if(res.status == 200) {
                            window.location.reload();
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
                            try {
                                var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                                layer.msg(errors[0]);return;
                            } catch (e) {
                                layer.msg(JSON.parse(XMLHttpRequest.responseText)['message']);return;
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
