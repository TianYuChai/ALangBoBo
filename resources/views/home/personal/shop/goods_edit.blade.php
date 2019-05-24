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
        img{
            width: 117px;
            height: 101px;
        }
    </style>
@endsection
@section('header')
@endsection
@section('content')
    <div class="modal-body" style="width: 900px">
        <div class="changeContent">
            <form class="form-horizontal" id="update_goods"
                  method="post" action="{{ route('personal.goods.update', ['id' => $item->id]) }}">
                @csrf
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               name="title" placeholder="请输入商品名称"
                               autocomplete="off" value="{{ $item->title }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">商品分类</label>
                    <div class="col-sm-10 goods">
                        <select class="form-control goods_cate" name="category[]">
                            @foreach($goodsCategorys['mainCategorys'] as $goodsMainCategory)
                                <option value="{{ $goodsMainCategory->id }}"
                                    {{ $item->main_category == $goodsMainCategory->id ? 'selected' : '' }}> {{ $goodsMainCategory->cate_name }} </option>
                            @endforeach
                        </select>
                        <select class="form-control goods_cate second" name="category[]" style="margin-top: 10px">
                            @foreach($goodsCategorys['goodsSubCategorys'] as $goodsSubCategory)
                                <option value="{{ $goodsSubCategory->id }}"
                                    {{ $item->sub_category == $goodsSubCategory->id ? 'selected' : '' }}> {{ $goodsSubCategory->cate_name }} </option>
                            @endforeach
                        </select>
                        <select class="form-control goods_cate three" name="category[]" style="margin-top: 10px" @if($item->three_category ==0) hidden @endif>
                            @foreach($goodsCategorys['goodsThreeCategorys'] as $goodsThreeCategorys)
                                <option value="{{ $goodsThreeCategorys->id }}"
                                    {{ $item->sub_category == $goodsThreeCategorys->id ? 'selected' : '' }}> {{ $goodsThreeCategorys->cate_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group goods_attribute" hidden>
                    <label for="inputPassword" class="col-sm-2 control-label">商品属性</label>
                    <div class="col-sm-10 attribute">

                    </div>
                </div>
                <div class="form-group" @if($item->attribute->isEmpty()) hidden @endif>
                    <label for="inputPassword" class="col-sm-2 control-label">已选商品属性</label>
                    <div class="col-sm-10">
                        @if(isset($item->attributes))
                            @foreach($item->attributes as $key => $value)
                                <p style="margin-top: 10px;">
                                    {{ $key }}
                                    @foreach($value as $v)
                                        <button type="button" class="btn btn-success del_attribute"
                                                style="margin-left: 10px;" data-action="{{ route('personal.goods.delattribute', ['id' => $v['id']]) }}">{{ $v['value'] }} X</button>
                                    @endforeach
                                    <br>
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">导航分类</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="nav_category">
                            @foreach($menuCategorys as $menuCategory)
                                <option value="{{ $menuCategory->id }}"
                                    {{ $item->nav_category == $menuCategory->id ? 'selected' : '' }}>{{ $menuCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">发货地址</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="address">
                            {{--<option value="">不选择，则为地址信息中设置的默认发货地址</option>--}}
                            @foreach($address as $address)
                                <option value="{{ $address->id }}"
                                    {{ $item->address == $address->id ? 'selected' : '' }}>{{ $address->address }}</option>
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
                               onblur="this.v();" autocomplete="off" value="{{ $item->total_price }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputPassword">成本</label>
                    <div class="input-group" style="width: 250px;margin-left: 165px;">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control"
                               name="cost_price" placeholder="单位：元"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();" autocomplete="off" value="{{ $item->cost_price }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputPassword">满意度</label>
                    <div class="input-group" style="width: 250px;margin-left: 165px;">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control"
                               name="satis_price" placeholder="单位：元"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();" autocomplete="off" value="{{ $item->satic_price }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputPassword">运费</label>
                    <div class="input-group" style="width: 250px;margin-left: 165px;">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control"
                               name="delivery_price" placeholder="不填写, 默认包邮"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();" autocomplete="off" value="{{ $item->delivery_price }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputPassword">包邮</label>
                    <div class="input-group" style="width: 250px;margin-left: 165px;">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control"
                               name="free_shipping" placeholder="满多少包邮"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();" autocomplete="off" value="{{ $item->free_price }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">库存</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               name="stock" placeholder="请输入库存"
                               onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)"
                               onblur="this.v();" autocomplete="off" value="{{ $item->stocks }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">类别</label>
                    <div class="col-sm-10">
                        <div class="has-warning">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="new_products" id="checkboxWarning"
                                           value="1" {{ $item->new_goods == 1 ? 'checked' : '' }}>
                                    新品
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">封面图</label>
                    <div class="col-sm-10">
                        <img src="{{ FileUpload::url('image', $item->cost_img) }}"
                             class="img-rounded">
                        <input type="file" id="cover" accept="image/*">
                        <input type="hidden" name="cover_img" value="{{ $item->cost_img }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">轮播图</label>
                    <div class="col-sm-10">
                        <img src="{{ asset('home/images/img/idImg.png') }}" class="img-rounded">
                        <input type="file" id="goods_graph" accept="image/*" multiple>
                    </div>
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 exhibition" style="margin-top: 10px;">
                       @foreach($item->shuff_img as $img)
                            <div class="display_img">
                                <img src="{{ FileUpload::url('image', $img->img) }}"
                                     class="img-rounded" style="width:117px; height:101px;">
                                <span class="del">X</span>
                                <input type="hidden" name="rotation_chart[]" value="{{ $img->img }}">
                            </div>
                       @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情</label>
                    <div class="col-sm-10">
                        <script id="ue-container" name="content"  type="text/plain">
                            {!! $item->content !!}
                        </script>
                    </div>
                </div>
            </form>
            <div class="form-group" style="text-align: right;margin-top: 20px;">
                <button type="button" class="btn btn-primary update">确认修改</button>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('bottom')
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
    $('.update').click(function () {
        var data = $('#update_goods').serializeArray();
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
            $("#update_goods").ajaxSubmit({
                success: function (res) {
                    if(res.status == 200) {
                        layer.msg(res.info);
                        setTimeout(function () {
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);
                            parent.location.reload();
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
                    if(!errors) {
                        layer.msg(JSON.parse(XMLHttpRequest.responseText)['message']);return;
                    }
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
                    if(!errors) {
                        layer.msg(JSON.parse(XMLHttpRequest.responseText)['message']);return;
                    }
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
        formData.append('type', 'goods');
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
                data:{img_path: img_path, type: 'goods'},
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
                        try {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        } catch (e) {
                            layer.msg(JSON.parse(XMLHttpRequest.responseText)['message']);return;
                        }
                    }
                }
            })
        });
    });
    /*已选属性删除*/
    $('.del_attribute').click(function () {
        var that = $(this);
        var url = that.data('action');
        layer.confirm('是否删除该图片?', function(index) {
            layer.close(index);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type:'GET',
                url:url,
                data:'',
                success: function (res) {
                    if(res.status == 200) {
                        that.remove();
                        if(!that.parent().has('button').length) {
                            that.parent().remove();
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
                        try {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        } catch (e) {
                            layer.msg(JSON.parse(XMLHttpRequest.responseText)['message']);return;
                        }
                    }
                }
            })
        });
    });
</script>
@endsection
