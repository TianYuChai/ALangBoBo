@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-订单管理')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_buyThings.css') }}"/>
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
        @include('home.personal.personal')
        <li class="firstLevel">
            <p>店铺管理</p>
            <ul>
                <li>
                    <a href="{{ route('personal.shop.index') }}">店招更换</a>
                </li>
                <li>
                    <a href="{{ route('personal.shop.menu') }}">导航菜单栏</a>
                </li>
                <li>
                    <a href="{{ route('personal.shop.banner') }}">店铺轮播</a>
                </li>
                <li>
                    <a href="{{ route('personal.shop.goods') }}" class="leftNavActive">商品管理</a>
                </li>
                <li>
                    <a href="{{ route('personal.shop.order', ['type' => 'allOrder']) }}">订单管理</a>
                </li>
            </ul>
        </li>
        <li class="firstLevel">
            <p>分享推广</p>
            <ul>
                <li>
                    <a href="{{ route('personal.shop.generalize') }}">推广管理</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<!--右边内容区-->
<div class="fl mgt-30">
    <div class="shInfoDiv shopCarContent">
        <!--列表部分-->
        <div class="receiveSend">
            <ul id="myTab" class="nav nav-tabs shopCarList">
                <li class="{{ $data['type'] == 'allOrder' ? 'active' :''}}">
                    <a href="{{ route('personal.shop.order', ['type' => 'allOrder']) }}">
                        所有订单
                    </a>
                </li>
                <li class="borderRight"></li>
                <li class="{{ $data['type'] == 'waitPay' ? 'active' :''}}">
                    <a href="{{ route('personal.shop.order', ['type' => 'waitPay']) }}">待付款</a>
                </li>
                <li class="borderRight"></li>
                <li class="{{ $data['type'] == 'waitSend' ? 'active' :''}}">
                    <a href="{{ route('personal.shop.order', ['type' => 'waitSend']) }}">待发货</a>
                </li>
                <li class="borderRight"></li>
                <li class="{{ $data['type'] == 'waitReceive' ? 'active' :''}}">
                    <a href="{{ route('personal.shop.order', ['type' => 'waitReceive']) }}">待收货</a>
                </li>
                <li class="borderRight"></li>
                <li class="{{ $data['type'] == 'waitEvaluate' ? 'active' :''}}">
                    <a href="{{ route('personal.shop.order', ['type' => 'waitEvaluate']) }}">待评价</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <!--tab1 所有订单-->
                <div class="tab-pane fade in active" id="allOrder">
                    <div class="orderSearch clearfix">
                        <form action="" method="get" id="subForm">
                            <input type="text" placeholder="输入订单号进行搜索" value="" name="order_id"/>
                            <a onclick="document:subForm.submit()">订单搜索</a>
                        </form>
                    </div>
                    <div class="orderList">
                        <table align="center" class="table tl" frame="box">
                            <thead class="thead" style="border:1px solid #e8e8e8;background-color: #f5f5f5;">
                            <tr>
                                <th class="tc" width="440">商品</th>
                                <th class="tc" width="70">单价</th>
                                <th class="tc" width="70">数量</th>
                                <th class="tc" width="110">实付款</th>
                                <th class="tc" width="110">付款方式</th>
                                <th class="tc" width="100">交易状态</th>
                                <th class="tc" class="tc">交易操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="6" class="tl checkboxTd">
                                    {{--<input type="checkbox" class="checkAll"/>全选--}}
                                </td>
                                {{--<td colspan="1" class="tc choosePage">--}}
                                {{--<a href="">上一页</a>--}}
                                {{--<a href="">下一页</a>--}}
                                {{--</td>--}}
                            </tr>
                            <!--全部订单列表-->
                            @foreach($data['items'] as $item)
                                <tr>
                                    <td colspan="7" class="pd-0">
                                        <table class="mgt-20">
                                            <!--此部分thead用于占位对齐，不具备实际意义-->
                                            <thead>
                                            <tr>
                                                <th class="tc" width="440"></th>
                                                <th width="70"></th>
                                                <th width="70"></th>
                                                <th width="110"></th>
                                                <th width="110"></th>
                                                <th width="100"></th>
                                                <th class="tc"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="7" class="tl pd-0">
                                                    <div class="shopProductTop">
                                                        {{--<input type="checkbox" name="checkbox"/>--}}
                                                        <span class="mgr-20">{{ $item->created_at }}</span>
                                                        <span class="mgr-20">订单号：<span>{{ $item->order_id }}</span></span>
                                                        <span class="mgr-20">购买者：{{ $item->user->account }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="clearfix shopcarListTd1 pd-20 pdl-10" width="430">
                                                    <img src="{{ FileUpload::url('image', $item->goodss->img) }}" class="fl"/>
                                                    <div class="fl">
                                                        <p>{{ $item->goodss->title }}</p>
                                                        @foreach($item->goodss->attribute as $attribute)
                                                            <p>{{ $attribute->name }}：<span>{{ $attribute->value }}</span></p>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="pd-20">￥{{ $item->fees }}</td>
                                                <td class="pd-20">{{ $item->num }}</td>
                                                <td class="pd-20">
                                                    <p>￥{{ $item->moneys }} </p>
                                                    @if($item->moneys > $item->free_price)
                                                        <p>包邮</p>
                                                    @else
                                                        <p>（含运费：￥{{ $item->delivery_fees }}）</p>
                                                    @endif
                                                </td>
                                                <td class="pd-20">{{$item->pay_methods}}</td>
                                                <td class="pd-20 tradeStatus">
                                                    @switch($item->status)
                                                        @case(100)
                                                        <a>交易关闭</a>
                                                        @break
                                                        @case(200)
                                                        <a>等待买家付款</a>
                                                        @break
                                                        @case(300)
                                                        <a>买家已付款, 等待发货</a>
                                                        @break
                                                        @case(400)
                                                        <a>等待收货 <br>
                                                            {{ $item->signcountdow }}完成签收
                                                        </a>
                                                        @break
                                                        @case(500)
                                                        <a>交易成功</a>
                                                        @break
                                                        @case(600)
                                                        <a>订单完成</a>
                                                        @break
                                                    @endswitch
                                                    <a href="javascript:void(0)" class="order_show" data-action="{{ route('personal.havegoods.show', ['id' => $item->id]) }}">订单详情</a>
                                                </td>
                                                <td class="pd-20">
                                                    @if($item->pay_method != 200 && $item->pay_method == 'subscribed'
                                                    && $item->timeout != '0000-00-00 00:00:00')
                                                        <a href="javascript:void(0)" class="timeBtn">认缴单, 等待付款</a>
                                                    @endif
                                                    @switch($item->status)
                                                        @case(300)
                                                            <a href="javascript:void(0)" class="sureBtn" data-action="{{ route('personal.order.deliveryorder', ['id' => $item->id]) }}">点击发货</a>
                                                        @break
                                                        @case(400)
                                                            <a class="deleteBtn edit_delivery_message" href="javascript:void(0)" data-action="{{ route('personal.order.editdeliveryorder', ['id' => $item->id]) }}">修改发货信息</a>
                                                        @break
                                                    @endswitch
                                                    @if(!in_array($item->status, [100, 200, 600]))
                                                        <a href="" class="deleteBtn">取消订单</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">
                            {{--<p class="fl"><input type="checkbox" class="checkAll"/>全选</p>--}}
                            <div class="paginationDiv fr">
                                {{ $data['items']->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('section')
<script type="text/javascript">
    $('.order_show').click(function () {
        let url = $(this).data('action');
        layer.open({
            type: 2,
            title: '订单详情',
            shadeClose: true,
            shade: 0.8,
            area: ['990px', '90%'],
            content: url
        });
    });
    /*发货*/
    $('.sureBtn').click(function () {
        let url = $(this).data('action');
        layer.confirm('确认发货？', {
            btn: ['是','否'] //按钮
        }, function(index){
            layer.close(index);
            layer.prompt({title: '快递公司名称', formType: 3}, function(name, index){
                layer.close(index);
                layer.prompt({title: '快递单号', formType: 3}, function(code, index){
                    layer.close(index);
                    let obj = {};
                    obj['name'] = name;
                    obj['code'] = code;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"POST",
                        url:url,
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
                });
            });
        });
    });
    /*修改发货信息*/
    $('.edit_delivery_message').click(function () {
        let url = $(this).data('action');
        layer.confirm('确认修改发货信息？', {
            btn: ['是','否'] //按钮
        }, function(index){
            layer.close(index);
            layer.prompt({title: '输入新的快递公司名称', formType: 3}, function(name, index){
                layer.close(index);
                layer.prompt({title: '输入新的快递单号', formType: 3}, function(code, index){
                    layer.close(index);
                    let obj = {};
                    obj['name'] = name;
                    obj['code'] = code;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"POST",
                        url:url,
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
                });
            });
        });
    });
</script>
@endsection
