@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-商品管理')
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
                <a href="../html/merchantCenter_buyThings.html">订单管理</a>
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
<div class="shInfoDiv shopCarContent">
    <!--列表部分-->
    <div class="receiveSend">
        <ul id="myTab" class="nav nav-tabs shopCarList">
            <li class="active">
                <a href="#productList" data-toggle="tab">
                    商品列表
                </a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <!--tab1 商品列表-->
            <div class="tab-pane fade in active" id="productList">
                <div class="productListTop clearfix">
                    <p><img src="{{ asset('home/images/icon/productList.png') }}" alt=""/>产品列表</p>
                    <a href="javascript:void(0)"  data-toggle="modal" data-target="#editProduct">+添加商品</a>
                </div>
                <form action="" method="get" id="subForm">
                    <div class="orderSearch clearfix">
                        <input type="text" placeholder="输入产品名称" name="title" value="{{ Input::get('title', '') }}"/>
                        <a onclick="document:subForm.submit()">查询</a>
                    </div>
                </form>
                <div class="orderList">
                    <table align="center" class="table tl" frame="box">
                        <thead class="thead" style="border:1px solid #e8e8e8;background-color: #ebecf0;">
                        <tr>
                            <th class="tl" width="200">商品名称</th>
                            <th class="tl" width="90">商品图片</th>
                            <th class="tl" width="100">价格 <a href="/personal/shop/goods?sort=total_fee"><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="100">库存 <a href="/personal/shop/goods?sort=stock"><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="100">销量 <a href="/personal/shop/goods?sort=sold"><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="100">可售数量</th>
                            <th class="tl" width="120">状态</th>
                            <th class="tl" width="120">发布时间 <a href="/personal/shop/goods?sort=created_at"><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl">操作</th>
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
                                            <img src="{{ FileUpload::url('image', $item->cost_img) }}"
                                                 style="width: 52px; height: 54px" class="fl productListImg"/>
                                        </div>
                                    </td>
                                    <td>￥{{ $item->total_price }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ $item->sold }}</td>
                                    <td>{{ $item->stocks }}</td>
                                    <td>
                                        <p class="productStatus">{{ $item->status_name }}</p>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="productOperat">
                                        <a href="javascript:void(0)" class="block edit" data-action="{{ route('personal.goods.edit', ['id' => $item->id]) }}">编辑商品</a>
                                        <a href="javascript:void(0)" class="block mgt-10 oper_status"
                                           data-action="{{ route('personal.goods.operstatus', ['id' => $item->id]) }}">立即{{ $item->status == 0 ? '下架' : '出售' }}</a>
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
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">商品名称</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                            name="title" placeholder="请输入商品名称" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword" class="col-sm-2 control-label">商品分类</label>
                                                <div class="col-sm-10 goods">
                                                    <select class="form-control goods_cate" name="category[]">
                                                        @foreach($goodsCategorys as $goodsCategory)
                                                            <option value="{{ $goodsCategory->id }}"> {{ $goodsCategory->cate_name }} </option>
                                                        @endforeach
                                                    </select>
                                                    <select class="form-control goods_cate second" name="category[]" style="margin-top: 10px" hidden></select>
                                                    <select class="form-control goods_cate three" name="category[]" style="margin-top: 10px" hidden></select>
                                                </div>
                                            </div>
                                            <div class="form-group goods_attribute" hidden>
                                                <label for="inputPassword" class="col-sm-2 control-label">商品属性</label>
                                                <div class="col-sm-10 attribute"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword" class="col-sm-2 control-label">导航分类</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="nav_category">
                                                        @foreach($menuCategorys as $menuCategory)
                                                            <option value="{{ $menuCategory->id }}">{{ $menuCategory->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword" class="col-sm-2 control-label">发货地址</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="address">
                                                        <option value="">不选择，则为地址信息中设置的默认发货地址</option>
                                                        @foreach($address as $address)
                                                            <option value="{{ $address->id }}">{{ $address->address }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">总价</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control money"
                                                           name="total_price" placeholder="单位：元"
                                                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                           onblur="this.v();" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">成本</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           name="cost_price" placeholder="单位：元"
                                                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                           onblur="this.v();" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">满意度</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           name="satis_price" placeholder="单位：元"
                                                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                           onblur="this.v();" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">运费</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           name="delivery_price" placeholder="不填写, 默认包邮"
                                                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                           onblur="this.v();" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">包邮</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           name="free_shipping" placeholder="满多少包邮"
                                                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                                                           onblur="this.v();" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">库存</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                           name="stock" placeholder="请输入库存"
                                                           onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)"
                                                           onblur="this.v();" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">类别</label>
                                                <div class="col-sm-10">
                                                    <div class="has-warning">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="new_products" id="checkboxWarning" value="1">
                                                                新品
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">封面图</label>
                                                <div class="col-sm-10">
                                                    <img src="{{ asset('home/images/img/idImg.png') }}" class="img-rounded">
                                                    <input type="file" id="cover" accept="image/*">
                                                    <input type="hidden" name="cover_img">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">轮播图</label>
                                                <div class="col-sm-10">
                                                    <img src="{{ asset('home/images/img/idImg.png') }}" class="img-rounded">
                                                    <input type="file" id="goods_graph" accept="image/*" multiple>
                                                </div>
                                                <label class="col-sm-2 control-label"></label>
                                                <div class="col-sm-10 exhibition" style="margin-top: 10px;" hidden>

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
                                        发布新产品
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
        $('.add').click(function () {
            var data = $('#add_goods').serializeArray();
            var message = {title: '商品名称', second_category : '分类', total_price: '总价', cost_price: '成本价',
                satis_price: '满意度价', delivery_price: '运费', free_shipping: '包邮', stock: '库存', new_products: '新品',
                cover_img: '封面图'};
            $.each(data, function (k, val) {
                if(val['name'] == 'title' && !val['value']) {
                    layer.msg('请填写'+ message[val['name']]); return false;
                }
                if(!$('.second').has('option').length) {
                    layer.msg('请选择分类, 不可选一级分类作为商品分类'); return false;
                }
                if((val['name'] == 'total_price' || val['name'] == 'cost_price'
                    || val['name'] == 'satis_price'||val['name'] == 'stock') && !val['value']) {
                    layer.msg('请填写'+ message[val['name']]); return false;
                }
                if((val['name'] == 'cover_img') && !val['value']) {
                    layer.msg('请上传'+ message[val['name']]); return false;
                }
                if(!$('.exhibition').has('input').length) {
                    layer.msg('请上传轮播图'); return false;
                }
            });
            if(!$('.layui-layer-msg').length) {
                $("#add_goods").ajaxSubmit({
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
        $('.oper_status').click(function () {
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
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                });
            });
        });
        // //删除操作
        // function deleteTr(nowTr){
        //     $(nowTr).parent().parent().remove();
        //     $(this).closest('tr').remove();  //清空当前行
        // }
        //监听商品分类
        $('.goods').on('change', '.goods_cate', function () {
            var that = $(this);
            var val = that.val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"post",
                url: "{{ route('personal.goods.select') }}",
                data:{id: val},
                success:function (res) {
                    var length = res.data.length;
                    if(length > 0) {
                        var htm = '';
                        for (let i = 0; i < length; i++) {
                            htm += '<option value="'+res.data[i]['id']+'"> '+res.data[i]['cate_name']+' </option>';
                        }
                        $('.' + res.level).html(htm);
                        $('.' + res.level).show();
                        if(res.level == "second") {
                            $('.three').hide();
                            let attibute = '';
                            let data = res.attribute;
                            if(!$.isEmptyObject(data)) {
                                for (let k in data) {
                                    attibute += k;
                                    for (let i = 0; i < data[k].length; i++) {
                                        attibute += '<label style="margin-left: 7px"><input type="checkbox" name="attribute['+k+'][]" value="'+data[k][i]['id']+'"> ' + data[k][i]['attribute_value'] + '</label>';
                                    }
                                    attibute += '<br/>';
                                }
                                $('.attribute').html(attibute);
                                $('.goods_attribute').show();
                            } else {
                                $('.goods_attribute').hide();
                            }
                        }
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
        //监听商品分类展示对应数据
        $('.second').on('change', function () {
            var that = $(this);
            var val = that.val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{{ route("personal.goods.attribute") }}",
                data:{id: val},
                success:function (res) {
                    let attibute = '';
                    let data = res.data;
                    if(!$.isEmptyObject(data)) {
                        for (let k in data) {
                            attibute += k;
                            for (let i = 0; i < data[k].length; i++) {
                                attibute += '<label style="margin-left: 7px">' +
                                    '<input type="checkbox" name="attribute['+k+'][]" value="'+data[k][i]['id']+'"> ' + data[k][i]['attribute_value'] + '</label>';
                            }
                            attibute += '<br/>';
                        }

                        $('.attribute').html(attibute);
                        $('.goods_attribute').show();
                    } else {
                        $('.goods_attribute').hide();
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
                                '<span class="del">X</span><input type="hidden" name="rotation_chart[]" value="'+res.url[i]+'"></div>';
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
    </script>
@endsection
