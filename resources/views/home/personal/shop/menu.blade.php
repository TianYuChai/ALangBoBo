@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-店铺分类')
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
                @include('home.personal.personal')
                <li class="firstLevel">
                    <p>店铺管理</p>
                    <ul>
                        <li>
                            <a href="{{ route('personal.shop.index') }}">店招更换</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.menu') }}" class="leftNavActive">导航菜单栏</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.banner') }}">店铺轮播</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.goods') }}">商品管理</a>
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
                            <th>排序</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbody tc">
                            @foreach($items as $item)
                                <tr>
                                    <td class="tc">
                                        {{ $item->name }}
                                    </td>
                                    <td>{{ $item->sort }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="mgr-10 edit" data-action="{{ route('personal.menu.edit', ['id' => $item->id]) }}">修改</a>
                                        <a href="javascript:void(0);" onclick='deleteTr(this, "{{ route('personal.menu.del', ['id' => $item->id]) }}");' class="mgr-10">删除</a>
                                    </td>
                                </tr>
                            @endforeach
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
                                    <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" alt=""/>添加分类</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent navMenuModal">
                                    <form class="changeSignForm" id="changeSignForm">
                                        <fieldset class="fieldset clearfix">
                                            <div class="jmNameDiv tr">
                                                分类名称：
                                                <input type="text"
                                                       class="jmName"
                                                       name="name"
                                                       placeholder="商铺分类的名称"
                                                       autocomplete="off" value="">
                                            </div>
                                            <div class="jmAddressDiv tr">
                                                排序：
                                                <input type="text"
                                                       class="jmAddress"
                                                       placeholder="值越大越靠前"
                                                       name="sort"
                                                       autocomplete="off"
                                                       value="100">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary add">
                                    保存
                                </button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
                <div class="modal fade" id="editNavMenu" tabindex="-1" role="dialog" aria-labelledby="editNavMenu" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title">
                                    <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" alt=""/>修改分类</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent navMenuModal">
                                    <form class="changeSignForm" id="changeEditForm">
                                        <fieldset class="fieldset clearfix">
                                            <div class="jmNameDiv tr">
                                                分类名称：
                                                <input type="text"
                                                       class="jmName"
                                                       name="edit_name"
                                                       placeholder="商铺分类的名称"
                                                       autocomplete="off" value="">
                                            </div>
                                            <div class="jmAddressDiv tr">
                                                排序：
                                                <input type="text"
                                                       class="jmAddress"
                                                       placeholder="值越大越靠前"
                                                       name="edit_sort"
                                                       autocomplete="off"
                                                       value="100">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary update">
                                    修改
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
@section('js')
    @parent
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
@show
@section('section')
    <script type="text/javascript">
        function deleteTr(nowTr, url){
            layer.confirm('是否删除该条记录?', function(index) {
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"get",
                    url:url,
                    data:"",
                    success:function (res) {
                        if(res.status == 200) {
                            $(nowTr).parent().parent().remove();
                            $(this).closest('tr').remove();  //清空当前行
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
        }

        $('.add').click(function () {
            var obj = {};
            var message = {name: '分类名称', sort: '排序'};
            var data = $('#changeSignForm').serializeArray();
            $.each(data, function (k, val) {
                if(!val['value']) {
                    layer.msg('请填写' + message[val['name']]);return;
                } else {
                    obj[val['name']] = val['value'];
                }
            });
            if(!$('.layui-layer-msg').length) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{{ route("personal.menu.store") }}",
                    data:obj,
                    success:function (res) {
                        if(res.status == 200) {
                            // layer.msg(res.info);
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
            }
        });

        $('.edit').click(function () {
            var url = $(this).data('action');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"get",
                url:url,
                data:"",
                success:function (res) {
                    if(res.status == 200) {
                        $('input[name=edit_name]').val(res.data['name']);
                        $('input[name=edit_sort]').val(res.data['sort']);
                        $('#editNavMenu').attr('action', res.data['url']);
                        $('#editNavMenu').modal('show');
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

        $('.update').click(function () {
            var obj = {};
            var message = {edit_name: '分类名称', edit_sort: '排序'};
            var data = $('#changeEditForm').serializeArray();
            var url = $('#editNavMenu').attr('action');
            $.each(data, function (k, val) {
                if(!val['value']) {
                    layer.msg('请填写' + message[val['name']]);return false;
                } else {
                    obj[val['name']] = val['value'];
                }
            });
            if(!$('.layui-layer-msg').length) {
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
            }
        });
    </script>
@endsection
