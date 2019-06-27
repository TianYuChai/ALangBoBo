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
                                <a href="javascript:void(0)" id="order_list">查单</a>
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
                                                    <a href="{{ route('demand.show', ['id' => $item->id]) }}" target="_blank">{{ $item->title }}</a>
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
                                                               data-action="{{ route('personal.demand.immediatelypay', ['id' => $item->id]) }}"
                                                            data-pay_method="{{ $item->pay_method }}">立即支付</a>
                                                            <a href="javascript:void(0)"
                                                               class="cancel"
                                                               data-action="{{ route('personal.demand.del', ['id' => $item->id]) }}">取消</a>
                                                        @break
                                                        @case(303)
                                                            <a href="JavaScript:void(0)"
                                                               class="edit"
                                                               data-action="{{ route('personal.demand.edit', ['id' => $item->id]) }}">修改</a>
                                                        @break
                                                        @case(304)
                                                            <a href="javascript:void(0)" id="confirm" data-action="{{ route('personal.demand.confirm', ['id' => $item->id]) }}">确认</a>
                                                        @break
                                                        @case(305)
                                                            <a href="javascript:void(0)"
                                                               data-toggle="modal"
                                                               data-target="#editEvaluate" class="evaluation" data-action="{{ route('personal.demand.high', ['id' => $item->id]) }}">评价</a>
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
                                                    <form class="form-horizontal" id="add_demand"
                                                          method="post" action="{{ route('personal.demand.store') }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">需求名称</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                       name="title" placeholder="请输入需求名称"
                                                                       autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword" class="col-sm-2 control-label">需求表现形式</label>
                                                            <div class="col-sm-10 goods">
                                                                <select class="form-control goods_cate" name="display">
                                                                    @foreach(\App\Http\Models\home\demandModel::$_DISPLAY as $k =>$display)
                                                                        <option value="{{ $k }}"> {{ $display }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword" class="col-sm-2 control-label">材料选择</label>
                                                            <div class="col-sm-10 goods">
                                                                <select class="form-control goods_cate" name="material">
                                                                    @foreach(\App\Http\Models\home\demandModel::$_MATERIAL as $key =>$material)
                                                                        <option value="{{ $key }}"> {{ $material }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">其他要求(可用,分割)</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                       name="other" placeholder="请输入其他要求, 如尺寸等"
                                                                       autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword">工期</label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <input type="text" class="form-control"
                                                                       name="time" placeholder="单位：天"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword"></label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <p class="help-block" style="color: red">总价 = 成本 + 满意度</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword">成本</label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <div class="input-group-addon">$</div>
                                                                <input type="text" class="form-control"
                                                                       name="cost" placeholder="单位：元"
                                                                       onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                                       onblur="this.v();" autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword">满意度</label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <div class="input-group-addon">$</div>
                                                                <input type="text" class="form-control"
                                                                       name="satisfaction" placeholder="单位：元"
                                                                       onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                                       onblur="this.v();" autocomplete="off" value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword">上架时长</label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <input type="text" class="form-control"
                                                                       name="refund_timeout" placeholder="单位：天, 支付后多长时间无人接单进行退款。不可超过三十天"
                                                                       value="" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"
                                                                       onkeyup="value=value.replace(/[^\d.]/g,'')">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">描述</label>
                                                            <div class="col-sm-10">
                                                                <textarea name="describe" id="" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">展示图</label>
                                                            <div class="col-sm-10">
                                                                <img src="{{ asset('home/images/img/idImg.png') }}"
                                                                     class="img-rounded">
                                                                <input type="file" id="cover" accept="image/*">
                                                                <input type="hidden" name="img" value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword" class="col-sm-2 control-label">支付选择</label>
                                                            <div class="col-sm-10 goods">
                                                                <select class="form-control goods_cate" name="pay_method">
                                                                    @foreach(["Alipay" => "支付宝","WeChat" => "微信"] as $s =>$pay)
                                                                        <option value="{{ $s }}"> {{ $pay }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">详情</label>
                                                            <div class="col-sm-10">
                                                                <script id="ue-container" name="content"  type="text/plain">

                                                                </script>
                                                            </div>
                                                        </div>
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
                                                                评价：
                                                                @for($i = 0; $i <= 10; $i++)
                                                                    <span class="relative">
                                                                {{ $i == 0 ? '' : $i }}0%
                                                            <img src="{{ asset('home/images/img/activeStar.png') }}" alt="" class="activeStar"/>
                                                        </span>
                                                                @endfor
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                                </button>
                                                <button type="button" class="btn btn-primary hign">
                                                    确认
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
    <!-- ueditor-mz 配置文件 -->
    <script type="text/javascript" src="{{  asset('home/ueditor/ueditor.config.js') }}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{ asset('home/ueditor/ueditor.all.js') }}"></script>
    <script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>
@endsection
@section('section')
    <script type="text/javascript">
        var ue = UE.getEditor('ue-container');
        ue.ready(function(){
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
        $(".manyidu span").on('click',function(){
            $(this).siblings().removeClass('manyiduActive');
            $(this).addClass('manyiduActive');
            $(this).siblings().children('img').attr('src','{{ asset('home/images/img/whiteStar.png') }}');
            $(this).children('img').attr('src','{{ asset('home/images/img/activeStar.png') }}');
        });
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
        $('.add').click(function () {
            let pay_method = $('select[name="pay_method"]').val();
            $("#add_demand").ajaxSubmit({
                success: function (res) {
                    if(pay_method == 'Alipay') {
                        $('body').append(res);
                        $("form").attr("target", "_blank");
                    } else {
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
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if (XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);
                            return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);
                            return;
                        }
                    } catch (e) {
                        if (XMLHttpRequest.statusText == 'Unauthorized') {
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);
                            parent.location.reload();
                            window.location.href = "{{ route('index.login') }}";
                        } else {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);
                            return;
                        }
                    }
                }
            });
        });
        /*封面图片--上传*/
        $("input[id='cover']").on('change', function () {
            var that = $(this);
            var file = that[0].files[0];
            var image = $('input[name="img"]');
            var image_path = image.val();
            that.prev().attr('src', URL.createObjectURL(file)).css({"width":"117px","height":"101px"});
            var formData = new FormData();
            formData.append('file', file);
            formData.append('image_path', image_path);
            formData.append('type', '');
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
                        image.val(res.url[0]);
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
        /*支付*/
        $('.pay').click(function () {
            let url = $(this).data('action');
            let pay_method = $(this).data('pay_method');
            layer.confirm('确认支付？',
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
                        if(pay_method == 'Alipay') {
                            $('body').append(res);
                            $("form").attr("target", "_blank");
                        } else {
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
        $('.edit').click(function () {
            let url = $(this).data('action');
            layer.open({
                type: 2,
                title: '修改需求',
                shadeClose: true,
                shade: 0.8,
                area: ['950px', '85%'],
                content: url,
            });
        });
        $('#order_list').click(function () {
            layer.open({
                type: 2,
                title: '查看',
                shadeClose: true,
                shade: 0.8,
                area: ['1210px', '85%'],
                content: "{{ route('personal.demand.list') }}",
            });
        });
        $('#confirm').click(function () {
            let url = $(this).data('action');
            layer.confirm('确认收货？',
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
                        layer.msg(res.info);
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    },
                    error:function (XMLHttpRequest) {
                        //返回提示信息
                        try {
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
        /*评价*/
        $('.evaluation').click(function () {
            let url = $(this).data('action');
            $('#changeSignForm').attr('action', url);
        });
        $('.hign').click(function () {
            let satisfaction = $.trim($('.manyiduActive').text());
            let url =  $('#changeSignForm').attr('action');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:url,
                data:{high: satisfaction},
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
    </script>
@endsection
