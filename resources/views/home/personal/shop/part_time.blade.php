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
                            <a href="{{ route('personal.shop.goods') }}">商品管理</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.partime.index') }}" class="leftNavActive">兼职管理</a>
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
                                <a href="javascript:void(0)"  data-toggle="modal" data-target="#editProduct">+添加信息</a>
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
                                        <th class="tl" width="90">兼职图片</th>
                                        <th class="tl" width="100">价格</th>
                                        <th class="tl" width="90">结算方式</th>
                                        <th class="tl" width="90">总工时</th>
                                        <th class="tl" width="150">发布时间</th>
                                        <th class="tl">操作</th>
                                        <th class="tl">查看</th>
                                    </tr>
                                    </thead>
                                    <tbody class="listTbody">
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <p class="fl productName">{{ $item->title }}</p>
                                            </td>
                                            <td>
                                                <div class="clearfix">
                                                    <img src="{{ FileUpload::url('image', $item->image) }}"
                                                         style="width: 52px; height: 54px" class="fl productListImg"/>
                                                </div>
                                            </td>
                                            <td>￥{{ $item->moneys }}</td>
                                            <td>{{ $item->settles }}</td>
                                            <td>{{ $item->time }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td class="productOperat">
                                                <a href="javascript:void(0)" class="block edit"
                                                   data-action="{{ route('personal.partime.edit', ['id' => $item->id]) }}">编辑</a>
                                                <a href="javascript:void(0)" class="block mgt-10 open_status"
                                                   data-action="{{ route('personal.partime.del', ['id' => $item->id]) }}">删除</a>
                                            </td>
                                            <td>
                                                <a href="JavaScript:void(0)" class="block mgt-10 send" data-action="{{ route('personal.partime.show', ['id' => $item->id]) }}">
                                                    查看投递记录
                                                </a>
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
                                                    <form class="form-horizontal" id="add_part_time"
                                                          method="post" action="{{ route('personal.partime.create') }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">兼职名称</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                       name="title" placeholder="请输入兼职名称" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword" class="col-sm-2 control-label">兼职分类</label>
                                                            <div class="col-sm-10 goods">
                                                                <select class="form-control category" name="category">
                                                                    @foreach($goodsCategorys as $goodsCategory)
                                                                        <option value="{{ $goodsCategory->id }}"> {{ $goodsCategory->cate_name }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword" class="col-sm-2 control-label">薪资计算方式</label>
                                                            <div class="col-sm-10 goods">
                                                                <select class="form-control settle" name="settle">
                                                                    @foreach($settle as $key => $item)
                                                                        <option value="{{ $key }}"> {{ $item }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">工作时长</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                       name="time" placeholder="请输入工作时长" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword">薪资</label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <div class="input-group-addon">$</div>
                                                                <input type="text" class="form-control money"
                                                                       name="total_price" placeholder="单位：元"
                                                                       onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                                       onblur="this.v();" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="inputPassword">描述</label>
                                                            <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                                <textarea name="describe" id="" cols="30"
                                                                          rows="5"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">展示图</label>
                                                            <div class="col-sm-10">
                                                                <img src="{{ asset('home/images/img/idImg.png') }}" class="img-rounded">
                                                                <input type="file" id="cover" accept="image/*">
                                                                <input type="hidden" name="cover_img">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                        <label class="col-sm-2 control-label">详情</label>
                                                        <div class="col-sm-10">
                                                        <script id="ue-container" name="content"  type="text/plain" style="height: 450px;"></script>
                                                            </div>
                                                            </div>
                                                            </form>
                                                            </div>
                                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                                </button>
                                                <button type="button" class="btn btn-primary add">
                                                    发布兼职
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
<script src="{{ asset('home/layer/laydate/laydate.js') }}"></script>
@endsection
@section('section')
<script type="text/javascript">
var ue = UE.getEditor('ue-container');
ue.ready(function(){
    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
});
laydate.render({
    elem: '#test1' //指定元素
});
$('.add').click(function () {
    $.each($('#add_part_time').serializeArray(), function (k, val) {
        if(!val['value']) {
            layer.msg('以上值不可为空'); return false;
        }
    });
    if(!$('.layui-layer-msg').length) {
        $("#add_part_time").ajaxSubmit({
            success: function (res) {
                if(res.status == 200) {
                    layer.msg(res.info);
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
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
                    if(!errors) {
                        layer.msg(JSON.parse(XMLHttpRequest.responseText)['message']);return;
                    }
                    for (var value in errors) {
                        layer.msg(errors[value][0]);return;
                    }
                }
            }
        });
    }
});
$('.edit').click(function () {
    let url = $(this).data('action');
    layer.open({
        type: 2,
        title: '修改商品',
        shadeClose: true,
        shade: 0.8,
        area: ['950px', '85%'],
        content: url,
    });
});
$('.open_status').click(function () {
    let url = $(this).data('action');
    layer.confirm('是否进行该操作？', {
        btn: ['是','否'] //按钮
    },  function(index){
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
/*封面图片--上传*/
$("input[id='cover']").on('change', function () {
    var that = $(this);
    var file = that[0].files[0];
    var image = $('input[name="cover_img"]');
    var image_path = image.val();
    that.prev().attr('src', URL.createObjectURL(file)).css({"width":"117px","height":"101px"});
    var formData = new FormData();
    formData.append('file', file);
    formData.append('image_path', image_path);
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
                var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                layer.msg(errors[0]);return;
            }
        }
    });
});
/*查看记录*/
$('.send').click(function () {
    let url = $(this).data('action');
    layer.open({
        type: 2,
        title: '投递记录',
        shadeClose: true,
        shade: 0.8,
        area: ['950px', '85%'],
        content: url,
    });
});
</script>
@endsection
