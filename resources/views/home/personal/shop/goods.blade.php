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
                <div class="orderSearch clearfix">
                    <input type="text" placeholder="输入产品名称"/>
                    <a>查询</a>
                </div>
                <div class="orderList">
                    <table align="center" class="table tl" frame="box">
                        <thead class="thead" style="border:1px solid #e8e8e8;background-color: #ebecf0;">
                        <tr>
                            <th width="50" class="tc"><input type="checkbox" class="checkAll"/></th>
                            <th class="tl" width="320">商品名称</th>
                            <th class="tl" width="100">价格 <a href=""><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="100">库存 <a href=""><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="100">销量 <a href=""><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="120">创建时间 <a href=""><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl" width="120">发布时间 <a href=""><img src="{{ asset('home/images/icon/sortIcon.png') }}" alt=""/></a></th>
                            <th class="tl">操作</th>
                        </tr>
                        </thead>
                        <tbody class="listTbody">
                        <tr>
                            <td class="tc checkboxTd"><input type="checkbox" name="checkbox"/></td>
                            <td>
                                <div class="clearfix">
                                    <img src="../images/img/productListImg.png" alt="" class="fl productListImg"/>
                                    <p class="fl productName">原创复古医生包 头层牛皮单肩斜挎包 真皮
                                        女包口金包手提包小挎包 </p>
                                </div>
                            </td>
                            <td>￥100.00</td>
                            <td>150</td>
                            <td>0</td>
                            <td>
                                <p>2018-09-02</p>
                                <p class="productStatus">出售中</p>
                            </td>
                            <td>2019-02-02</td>
                            <td class="productOperat">
                                <a href="" class="block">编辑商品</a>
                                <a href="" class="block mgt-10">立即下架</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="editProduct" aria-hidden="true">
                        <div class="modal-dialog modalWidth">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel-jm">
                                        <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" />编辑/添加产品</p>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="changeContent">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">商品名称</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="请输入商品名称">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword" class="col-sm-2 control-label">商品分类</label>
                                                <div class="col-sm-10 goods">
                                                    <select class="form-control goods_cate">
                                                        @foreach($goodsCategorys as $goodsCategory)
                                                            <option value="{{ $goodsCategory->id }}"> {{ $goodsCategory->cate_name }} </option>
                                                        @endforeach
                                                    </select>
                                                    <select class="form-control goods_cate second" style="margin-top: 10px" hidden></select>
                                                    <select class="form-control goods_cate three" style="margin-top: 10px" hidden></select>
                                                </div>
                                            </div>
                                            <div class="form-group goods_attribute" hidden>
                                                <label for="inputPassword" class="col-sm-2 control-label">商品属性</label>
                                                <div class="col-sm-10 attribute"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword" class="col-sm-2 control-label">导航分类</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control">
                                                        @foreach($menuCategorys as $menuCategory)
                                                            <option value="{{ $menuCategory->id }}">{{ $menuCategory->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword" class="col-sm-2 control-label">发货地址</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control">
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
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="单位：元">
                                                    <div class="input-group-addon">.00</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">成本</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="单位：元">
                                                    <div class="input-group-addon">.00</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">满意度</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="单位：元">
                                                    <div class="input-group-addon">.00</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">运费</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="不填写, 默认包邮">
                                                    <div class="input-group-addon">.00</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="inputPassword">包邮</label>
                                                <div class="input-group" style="width: 250px;margin-left: 165px;">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="满多少包邮">
                                                    <div class="input-group-addon">.00</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">库存</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                           id="inputPassword" placeholder="请输入库存">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">类别</label>
                                                <div class="col-sm-10">
                                                    <div class="has-warning">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="checkboxWarning" value="option1">
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
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">轮播图</label>
                                                <div class="col-sm-10">
                                                    <img src="{{ asset('home/images/img/idImg.png') }}" alt="..." class="img-rounded">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                    </button>
                                    <button type="button" class="btn btn-primary">
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
@endsection
@section('section')
    <script type="text/javascript">
        //删除操作
        function deleteTr(nowTr){
            //多一个parent就代表向前一个标签,
            // 本删除范围为<td><tr>两个标签,即向前两个parent
            //如果多一个parent就会删除整个table
            $(nowTr).parent().parent().remove();
            $(this).closest('tr').remove();  //清空当前行
        }
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
                                        attibute += '<label style="margin-left: 7px"><input type="checkbox" name="'+k+'[]" value="'+data[k][i]['id']+'"> ' + data[k][i]['attribute_value'] + '</label>';
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
                                attibute += '<label style="margin-left: 7px"><input type="checkbox" name="'+k+'[]" value="'+data[k][i]['id']+'"> ' + data[k][i]['attribute_value'] + '</label>';
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
    </script>
@endsection
