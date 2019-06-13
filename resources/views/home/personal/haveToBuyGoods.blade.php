@extends('home.public.subject')
@section('title', '阿朗博波-已买到的宝贝')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_buyThings.css') }}"/>
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
                            <a href="{{ route('personal.havegoods', ['type' => 'allOrder']) }}"  class="leftNavActive">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.sendtime.index') }}">兼职投递记录</a>
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
                        <li class="{{ $data['type'] == 'allOrder' ? 'active' :''}}">
                            <a href="{{ route('personal.havegoods', ['type' => 'allOrder']) }}">
                                所有订单
                            </a>
                        </li>
                        <li class="borderRight"></li>
                        <li class="{{ $data['type'] == 'waitPay' ? 'active' :''}}">
                            <a href="{{ route('personal.havegoods', ['type' => 'waitPay']) }}">待付款</a>
                        </li>
                        <li class="borderRight"></li>
                        <li class="{{ $data['type'] == 'waitSend' ? 'active' :''}}">
                            <a href="{{ route('personal.havegoods', ['type' => 'waitSend']) }}">待发货</a>
                        </li>
                        <li class="borderRight"></li>
                        <li class="{{ $data['type'] == 'waitReceive' ? 'active' :''}}">
                            <a href="{{ route('personal.havegoods', ['type' => 'waitReceive']) }}">待收货</a>
                        </li>
                        <li class="borderRight"></li>
                        <li class="{{ $data['type'] == 'refund' ? 'active' :''}}">
                            <a href="{{ route('personal.havegoods', ['type' => 'refund']) }}">退款</a>
                        </li>
                        <li class="borderRight"></li>
                        <li class="{{ $data['type'] == 'waitEvaluate' ? 'active' :''}}">
                            <a href="{{ route('personal.havegoods', ['type' => 'waitEvaluate']) }}">评价与完成</a>
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
                                                                @case(300)
                                                                    <a>等待商家发货</a>
                                                                @break
                                                                @case(400)
                                                                    <a>已发货, 请查收 <br>
                                                                        {{ $item->signcountdow }}完成签收
                                                                    </a>
                                                                @break
                                                                @default
                                                                    @if(in_array($item->status, [500, 600]))
                                                                        @if($item->evaluation)
                                                                            <a>交易成功, 已评价</a>
                                                                        @else
                                                                            <a>交易成功</a>
                                                                        @endif
                                                                    @endif
                                                                @break
                                                            @endswitch
                                                                <a href="javascript:void(0)" class="order_show" data-action="{{ route('personal.havegoods.show', ['id' => $item->id]) }}">订单详情</a>
                                                        </td>
                                                        <td class="pd-20">
                                                            @if($item->pay_method != 200 && $item->pay_method == 'subscribed'
                                                            && $item->timeout != '0000-00-00 00:00:00')
                                                                <a href="javascript:void(0)" data-url="{{ route('personal.havegoods.pay', ['id' => $item->id]) }}" class="payMoneyBtn">立即付款</a>
                                                            @endif
                                                            @if(in_array($item->status, [200]))
                                                                <a href="javascript:void(0)"
                                                                   data-url="{{ route('personal.havegoods.pay', ['id' => $item->id]) }}"
                                                                   class="payMoneyBtn">立即付款</a>
                                                                <a href="javascript:void(0)" class="deleteBtn del_order" data-action="{{ route('personal.havegoods.delorder', ['id' => $item->id]) }}">取消订单</a>
                                                            @elseif(in_array($item->status, [300, 400, 500, 600]))
                                                                @switch($item->status)
                                                                    @case(400)
                                                                        <a href="javascript:void(0)"
                                                                           class="sureBtn" data-action="{{ route('personal.havegoods.sign', ['id' => $item->id]) }}">确认收货</a>
                                                                    @break
                                                                    @case(500)
                                                                        @if(!$item->evaluation)
                                                                            <a class="deleteBtn evaluation"
                                                                               data-action="{{ route('personal.havegoods.evaluation', ['id' => $item->id]) }}"
                                                                               data-toggle="modal"
                                                                               data-target="#editEvaluate">评价</a>
                                                                        @endif
                                                                        <a class="deleteBtn" href="{{ url('details', ['id' => $item->sid]) }}">再次购买</a>
                                                                    @break
                                                                @endswitch
                                                                @if($item->pay_method == 'paidin' || $item->pay_method == 'subscribed' && $item->timeout == '0000-00-00 00:00:00')
                                                                    @if(in_array($item->status, [300, 400]))
                                                                            <a href="javascript:void(0)" class="deleteBtn refund" data-action="{{ route('personal.havegoods.refundorder', ['id' => $item->id]) }}">申请退款</a>
                                                                    @endif
                                                                @endif
                                                            @elseif(in_array($item->status, [700, 800, 900]))
                                                                    <a style="color: red">{{ $item->status_name }}</a>
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
                        <div class="modal fade" id="editEvaluate" tabindex="-1" role="dialog" aria-labelledby="editEvaluate" aria-hidden="true">
                            <div class="modal-dialog modalWidth">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel-jm">
                                            <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" alt=""/>发表评价</p>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="changeContent">
                                            <form class="changeSignForm" id="changeSignForm" action="">
                                                <fieldset class="fieldset clearfix">
                                                    <div class="manyidu mgt-20">
                                                        商品满意度评价：
                                                        @for($i = 0; $i <= 10; $i++)
                                                            <span class="relative">
                                                            {{ $i == 0 ? '' : $i }}0%
                                                            <img src="{{ asset('home/images/img/activeStar.png') }}" alt="" class="activeStar"/>
                                                        </span>
                                                        @endfor
                                                    </div>
                                                    <div class="productPingjia mgt-20">
                                                        商品评价：
                                                        <textarea id="goods_evaluation" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="servicePingjia mgt-20">
                                                        服务评价：
                                                        <textarea id="service_evaluation" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="relative bannerImgDiv clearfix mgt-20">
                                                        <p class="inline-block mgr-20 mgl-15 fl">晒图片：</p>
                                                        <!--晒图片-1-->
                                                        <div class="fl mgr-10">
                                                            <img src="{{ asset('home/images/img/idImg.png') }}" class="img-rounded" style="margin-left: -35px;">
                                                            <input type="file" id="goods_graph" accept="image/*" multiple>
                                                            <label class="col-sm-2 control-label"></label>
                                                            <div class="col-sm-10 exhibition" style="margin-top: 10px;" hidden>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mgt-10 mgl-80">
                                                        <input type="checkbox" id="anonymous"/>匿名评价
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                        </button>
                                        <button type="button" class="btn btn-primary confirm">
                                            确认
                                        </button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('section')
    <script type="text/javascript">
        //满意度评价 点亮星星功能
        $(".manyidu span").on('click',function(){
            $(this).siblings().removeClass('manyiduActive');
            $(this).addClass('manyiduActive');
            $(this).siblings().children('img').attr('src','{{ asset('home/images/img/whiteStar.png') }}');
            $(this).children('img').attr('src','{{ asset('home/images/img/activeStar.png') }}');
        });
        //全选点击事件
        $('.checkAll').on('click', function () {
            $("input[name='checkbox']").prop("checked", this.checked);
        });
        $("input[name='checkbox']").on('click',function() {
            var $checkboxs = $("input[name='checkbox']");
            $(".all").prop("checked" , $checkboxs.length == $checkboxs.filter(":checked").length ? true :false);
        });
        //删除订单操作
        function deleteOrder(nowTr){
            //多一个parent就代表向前一个标签,
            // 本删除范围为<td><tr>两个标签,即向前两个parent
            //如果多一个parent就会删除整个table
            $(nowTr).parent().parent().parent().parent().parent().parent().parent().remove();
            //$(this).closest('tr').remove();  //清空当前行
        }
        /*订单详情*/
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
        /*签收*/
        $('.sureBtn').click(function () {
            let url = $(this).data('action');
            layer.confirm('是否已确认收到货品？', {
                btn: ['是','否'] //按钮
            }, function(index) {
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"GET",
                    url:url,
                    data:'',
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
        /*取消订单*/
        $('.del_order').click(function () {
            let url = $(this).data('action');
            layer.confirm('是否取消订单？', {
                btn: ['是','否'] //按钮
            }, function(index) {
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"GET",
                    url:url,
                    data:'',
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
        /*申请退款*/
        $('.refund').click(function () {
            let url = $(this).data('action');
            layer.prompt({title: '填写退款理由', formType: 2}, function(text, index){
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:url,
                    data:{message: text},
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
        /*轮播图--上传*/
        $("input[id='goods_graph']").on('change', function () {
            var that = $(this);
            var file = that[0].files;
            var formData = new FormData();
            for (let i = 0; i < file.length; i++) {
                formData.append('file[]', file[i]);
            }

            formData.append('type', 'layui');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route("file.upload") !!}",
                processData: false,
                contentType: false,
                data:formData,
                success:function (res) {
                    if(res.status == 200) {
                        let htm = '';
                        let length = res.url.length;
                        for (let i = 0; i < length; i++) {
                            htm += '<div class="display_img"><img src="{{ FileUpload::url('image') }}'+res.url[i]+'" class="img-rounded" style="width:117px; height:101px;">' +
                                '<span class="del">X</span><input type="hidden" name="rotation_chart" value="'+res.url[i]+'"></div>';
                        }
                        $('.exhibition').show();
                        $('.exhibition').append(htm);
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    try {
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
        /*图片--删除*/
        $('.exhibition').on('click', '.del', function () {
            var that = $(this);
            var img_path = that.next().val();
            layer.confirm('是否删除该图片?', function(index) {
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type:'POST',
                    url:"{!! route('file.del') !!}",
                    data:{img_path: img_path},
                    success: function (res) {
                        if(res.status == 200) {
                            that.prev().remove();
                            that.next().remove();
                            that.remove();
                            if(!$('.exhibition').has('input').length) {
                                $('.exhibition').hide();
                            }
                        }
                    },
                    error:function (XMLHttpRequest) {
                        //返回提示信息
                        try {
                            var errors = XMLHttpRequest.responseJSON.errors;
                            for (var value in errors) {
                                layer.msg(errors[value][0]);return;
                            }
                        } catch (e) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                })
            });
        });

        $('.evaluation').click(function () {
            let url = $(this).data('action');
            $('#changeSignForm').attr('action', url);
        });
        /*订单发布评价*/
        $('.confirm').click(function () {
            let satisfaction = $.trim($('.relative .manyiduActive').text());
            let url = $('#changeSignForm').attr('action');
            if(satisfaction == '') {
               layer.msg('请对该订单进行评分'); return false;
            }
            let goods_evaluation = $('#goods_evaluation').val();
            let service_evaluation = $('#service_evaluation').val();
            let anonymous = $('#anonymous').is(':checked');
            let images = [];
            $('input[name="rotation_chart"]').each(function () {
                images.push($(this).val());
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:url,
                data:{satisfaction: satisfaction,
                        goods_evaluation: goods_evaluation,
                        service_evaluation: service_evaluation,
                        anonymous: anonymous,
                     images: images},
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
        /*支付*/
        $('.payMoneyBtn').click(function () {
            let url = $(this).data('url');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"GET",
                url:url,
                data:"",
                success:function (res) {
                    $('body').append(res);
                    $("form").attr("target", "_blank");
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
        })
    </script>
@endsection
