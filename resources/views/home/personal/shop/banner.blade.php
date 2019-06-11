@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-店铺轮播')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/common/base.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/common/normalize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_shopSign.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_bannerList.css') }}"/>
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
            margin-left: 85px;
        }
        /*img{*/
        /*width: 110px;*/
        /*height: 100px;*/
        /*}*/
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
                            <a href="{{ route('personal.shop.banner') }}" class="leftNavActive">店铺轮播</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.goods') }}">商品管理</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.partime.index') }}">兼职管理</a>
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
                <p>店铺轮播</p>
            </div>
            <div class="shInfoDiv">
                <a href="" class="changeSignBtn" data-toggle="modal" data-target="#addBannerModal">
                    <img src="{{ asset('home/images/icon/changeIcon.png') }}" alt=""/>
                    添加内容
                </a>
                <div class="changeSignTable">
                    <table align="center" class="table" frame="box">
                        <thead class="thead">
                        <tr>
                            <th width="120px">url</th>
                            <th>图片</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbody tc">
                            @foreach($items as $item)
                                <tr>
                                    <td width="120px">
                                        <a href="{{ $item->url }}" target="_blank"> {{ $item->url }} </a>
                                    </td>
                                    <td>
                                        <img src="{{ FileUpload::url('image', $item->image) }}" alt="" class="bannerListImg"/>
                                    </td>
                                    <td>{{ $item->sort }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="bannerEditBtn mgr-10 edit" data-action="{{ route('personal.banner.edit', ['id' => $item->id]) }}">
                                            <img src="{{ asset('home/images/icon/bannerEdit.png') }}"/>修改
                                        </a>
                                        <a href="javascript:void(0);" onclick='deleteTr(this, "{{ route('personal.banner.del', ['id' => $item->id]) }}");' class="bannerDeleteBtn"><img
                                                    src="{{ asset('home/images/icon/bannerDelete.png') }}"/>删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog" aria-labelledby="addBannerModal" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel-jm">
                                    <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" alt=""/>添加内容</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent">
                                    <form class="changeSignForm" id="changeSignForm" method="get" action="">
                                        <fieldset class="fieldset clearfix">
                                            <div class="urlDiv tr">
                                                域名：
                                                <input type="text"
                                                       class="url"
                                                       id="url"
                                                       name="url"
                                                       autocomplete="off" placeholder="网址">
                                            </div>
                                            <div class="sortDiv tr">
                                                排序：
                                                <input
                                                    type="text"
                                                    class="sort"
                                                    id="sort"
                                                    name="sort"
                                                    autocomplete="off" placeholder="值越大越靠前">
                                            </div>
                                            <div class="relative bannerImgDiv">
                                                <p class="inline-block mgr-20 mgl-15">图片：</p>
                                                <img src="{{ asset('home/images/img/idImg.png') }}" class="jmImg"/>
                                                <input type="file" class="file" accept="image/*">
                                                <input type="hidden" name="img" value="">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary add">
                                    提交
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="editBannerModal" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel-jm">
                                    <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" alt=""/>修改内容</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent">
                                    <form class="changeSignForm" id="changeEditForm">
                                        <fieldset class="fieldset clearfix">
                                            <div class="urlDiv tr">
                                                域名：
                                                <input type="text"
                                                       class="url"
                                                       id="url"
                                                       name="edit_url"
                                                       autocomplete="off" placeholder="网址">
                                            </div>
                                            <div class="sortDiv tr">
                                                排序：
                                                <input
                                                        type="text"
                                                        class="sort"
                                                        id="sort"
                                                        name="edit_sort"
                                                        autocomplete="off" placeholder="值越大越靠前">
                                            </div>
                                            <div class="relative bannerImgDiv">
                                                <p class="inline-block mgr-20 mgl-15">图片：</p>
                                                <img src="{{ asset('home/images/img/idImg.png') }}" class="jmImg" id="image"/>
                                                <input type="file" class="file" accept="image/*">
                                                <input type="hidden" name="img" value="" id="edit_img">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary update">
                                    提交
                                </button>
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
        $('.add').click(function () {
            var obj = {};
            var message = {url: '域名', sort: '排序', img: '图片'};
            var data = $('#changeSignForm').serializeArray();
            $.each(data, function (k, val) {
                if(!val['value']) {
                    layer.msg(val['name'] == 'img' ? '请上传' : '请输入' + message[val['name']]); return false;
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
                    url:"{{ route("personal.banner.store") }}",
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
                url: url,
                data:"",
                success:function (res) {
                    if(res.status == 200) {
                       $("input[name=edit_url]").val(res.data['url']);
                       $("input[name=edit_sort]").val(res.data['sort']);
                       $("#image").attr('src', res.data['image_url']);
                       $("#edit_img").val(res.data['image']);
                       $("#editBannerModal").attr('action', res.data['action']);
                       $("#editBannerModal").modal('show');
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
            var message = {edit_url: '域名', edit_sort: '排序', img: '图片'};
            var data = $('#changeEditForm').serializeArray();
            var url = $("#editBannerModal").attr('action');
            $.each(data, function (k, val) {
                if(!val['value']) {
                    layer.msg(val['name'] == 'img' ? '请上传' : '请输入' + message[val['name']]); return false;
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
        //删除操作
        function deleteTr(nowTr, url){
            layer.confirm('是否删除该条记录?', function(index) {
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"get",
                    url: url,
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
        };
        /*图片--上传*/
        $("input[type='file']").on('change', function () {
            var that = $(this);
            var file = that[0].files[0];
            var image = $('input[name=img]');
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
    </script>
@endsection
