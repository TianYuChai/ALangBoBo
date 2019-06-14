@extends('home.public.subject')
@section('title', '阿朗博波-个人中心-百录倩影管理')
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
                            <a href="{{ route('personal.sendtime.index') }}">兼职投递记录</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.demand.index') }}" class="leftNavActive">百录倩影</a>
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
                                百录倩影列表
                            </a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <!--tab1 商品列表-->
                        <div class="tab-pane fade in active" id="productList">
                            <div class="productListTop clearfix">
                                <p><img src="{{ asset('home/images/icon/productList.png') }}" alt=""/>百录倩影列表</p>
                                <a href="javascript:void(0)"  data-toggle="modal" data-target="#editProduct">+添加</a>
                            </div>
                            <form action="" method="get" id="subForm">
                                <div>
                                    <select name="status" id="status">
                                        @foreach(['' => '全部']+\App\Http\Models\home\demandModel::$_STATUS as $key => $status)
                                            <option value="{{ $key }}" {{ $key == Input::get('status', '') ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="orderSearch clearfix">
                                    <input type="text" placeholder="输入名称" name="title" value="{{ Input::get('title', '') }}"/>
                                    <a onclick="document:subForm.submit()">查询</a>
                                </div>
                            </form>
                            <div class="orderList">
                                <table align="center" class="table tl" frame="box">
                                    <thead class="thead" style="border:1px solid #e8e8e8;background-color: #ebecf0;">
                                    <tr>
                                        <th class="tl" width="200">订单号</th>
                                        <th class="tl" width="200">名称</th>
                                        <th class="tl" width="90">状态</th>
                                        <th class="tl" width="90">创建时间</th>
                                        <th class="tl" width="90">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody class="listTbody">
                                        @foreach($items as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->order_id }}
                                                </td>
                                                <td>
                                                    <a href="" target="_blank">{{ $item->title }}</a>
                                                </td>
                                                <td>
                                                    {{ $item->status_name }}
                                                </td>
                                                <td>
                                                    {{ $item->created_at }}
                                                </td>
                                                <td>
                                                    @switch($item->status)
                                                        @case(302)
                                                            <a href="JavaScript:void(0)"
                                                               class="pay"
                                                               data-action="">立即支付</a>
                                                            <a href="JavaScript:void(0)"
                                                               class="edit"
                                                               data-action="">修改</a>
                                                            <a href="javascript:void(0)"
                                                               class="cancel"
                                                               data-action="{{ route('personal.demand.del', ['id' => $item->id]) }}">取消</a>
                                                        @break
                                                        @case(304)
                                                            <a href="javascript:void(0)">确认</a>
                                                        @break
                                                        @case(305)
                                                            <a href="javascript:void(0)">评价</a>
                                                        @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="text-align: right;">
                                    {!! $items->links() !!}
                                </div>
                                <div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="editProduct" aria-hidden="true">
                                    <div class="modal-dialog modalWidth">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    &times;
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel-jm">
                                                    <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" />添加产品</p>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="changeContent">
                                                    <form class="form-horizontal" id="add_goods"
                                                          method="post" action="{{ route('personal.goods.store') }}">
                                                        @csrf

                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                                </button>
                                                <button type="button" class="btn btn-primary add">
                                                    发布
                                                </button>
                                            </div>
                                        </div>
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
@section('shop')
@endsection
@section('js')
    @parent
    <script src="{{ asset('home/js/public.js') }}"></script>
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection
@section('section')
    <script type="text/javascript">
        $('.cancel').click(function () {
            let url  = $(this).data('action');
            let that = $(this);
            layer.confirm('确认取消？',
                {btn: ['确定', '取消'], title: "提示"}, function (index) {
                    layer.close(index);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"get",
                        url:url,
                        data:'',
                        success:function (res) {
                            if(res.status == 200) {
                                that.parent().parent().remove();
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
                                if(XMLHttpRequest.statusText == 'Unauthorized') {
                                    window.location.href = "{{ route('index.login') }}";
                                } else {
                                    var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                                    layer.msg(errors[0]);return;
                                }
                            }
                        }
                    });
            });
        });
    </script>
@endsection
