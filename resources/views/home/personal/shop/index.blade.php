@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-店招更换')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_shopSign.css') }}"/>
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
                            <a href="{{ route('personal.shop.index') }}" class="leftNavActive">店招更换</a>
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
                            <a href="../html/merchantCenter_buyThings.html">订单管理</a>
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
                <p>商户资料</p>
            </div>
            <div class="shInfoDiv">
                <!--判断当前店铺 为 加盟店，直营店还是网店， 显示对应的添加弹框-->
                <!--加盟店 状态更改  data-target="#changeSign-jm"     -->
                <!--直营店 状态更改  data-target="#changeSign-zy"-->
                <!--网店 状态更改  data-target="#changeSign-net"-->
                <a href="" class="changeSignBtn" data-toggle="modal" data-target="#changeSign-jm">
                    <img src="{{ asset('home/images/icon/changeIcon.png') }}" alt=""/>
                    修改内容
                </a>
                <div class="changeSignTable">
                    <table align="center" class="table" frame="box">
                        <thead class="thead">
                        <tr>
                            <th>店铺名称</th>
                            <th>商标</th>
                            <th>二维码</th>
                            <th>地址</th>
                            {{--<th>操作</th>--}}
                        </tr>
                        </thead>
                        <tbody class="tbody tc">
                        <tr>
                            <td>{{ Auth::guard('web')->user()->merchant['shop_name'] }}</td>
                            <td>
                                <img src="{{ Auth::guard('web')->user()->merchant['trademark'] ?
                                                FileUpload::url('image', Auth::guard('web')->user()->merchant['trademark']) : '未上传' }}" alt="" class="shopSign"/>
                            </td>
                            <td>
                                <img src="{{ Auth::guard('web')->user()->merchant['qr_code'] ?
                                                FileUpload::url('image', Auth::guard('web')->user()->merchant['qr_code']) : '未上传' }}" alt="" class="shopSign"/>
                            </td>
                            <td>{{ Auth::guard('web')->user()->merchant['address'] }}</td>
                            {{--<td>--}}
                                {{--<a href="javascript:void(0);" onclick='deleteTr(this);' class="mgr-10">删除</a>--}}
                                {{--<a href="">查看</a>--}}
                            {{--</td>--}}
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--加盟店添加内容弹窗   如果是加盟店则显示此部分 id = changeSign-jm  -->
                <div class="modal fade" id="changeSign-jm" tabindex="-1"
                     role="dialog" aria-labelledby="myModalLabel-jm" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel-jm">
                                    <p class="changeContentTip"><img src="{{ asset('home/images/icon/changeContentIcon.png') }}" alt=""/>更换标志</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent">
                                    <form class="changeSignForm" id="changeSignForm-jm" method="get" action="">
                                        <fieldset class="fieldset clearfix">
                                            <div class="jmNameDiv tr">
                                                店铺名称：
                                                <input type="text"
                                                       class="jmName"
                                                       id="jmName"
                                                       name="name"
                                                       autocomplete="off" value="{{ Auth::guard('web')->user()->merchant['shop_name'] }}">
                                            </div>
                                            <div class="jmAddressDiv tr">
                                                地址：
                                                <input type="text"
                                                       class="jmAddress"
                                                       id="Address"
                                                       name="address"
                                                       autocomplete="off"
                                                value="{{ Auth::guard('web')->user()->merchant['arrdess'] }}">
                                            </div>
                                            <div class="relative">
                                                <p class="inline-block mgr-20 mgl-15">商标：</p>
                                                <img src="{{ Auth::guard('web')->user()->merchant['trademark'] ?
                                                FileUpload::url('image', Auth::guard('web')->user()->merchant['trademark']) : asset('home/images/img/idImg.png') }}" class="jmImg"
                                                style="width: 117px; height: 101px"/>
                                                <!--<input type="file" class="file jmUpload" id="jm" name="jm">-->
                                                <!--浏览按钮-->
                                                <!--点击浏览按钮，显示上传预览弹框-->
                                                <img src="{{ asset('home/images/img/changeSignUpload.png') }}"
                                                     alt=""
                                                     class="uploadImg"/>
                                                <!--<input type="file" class="file netUpload" id="net" name="net">-->
                                                <div class="shangchuan" style="display: none;">
                                                    <form name="form0" id="form0">
                                                        <input type="file" name="file0" id="file0" accept="image/*"/>
                                                        <p class="shangchuanType">仅支持jpg、gif、png、jpeg图片文件，且文件小于5M</p>
                                                        <input type="hidden" name="head">
                                                        <img src="" id="img0" style="width: 86px;height: 53px;">
                                                        <button type="submit" class="shangchuanSave" onclick="return false;">保存</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="relative">
                                                <p class="inline-block mgr-20 mgl-15">二维码：</p>
                                                <img src="{{ Auth::guard('web')->user()->merchant['qr_code'] ?
                                                FileUpload::url('image', Auth::guard('web')->user()->merchant['qr_code'])
                                                : asset('home/images/img/idImg.png') }}" class="jmImg"
                                                     style="width: 117px; height: 101px"/>
                                                <input type="file" name="code">
                                                <input type="hidden" name="sub_code">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary">
                                    确定
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
@section('section')
<script>
    //    删除操作
    function deleteTr(nowTr){
        $(nowTr).parent().parent().remove();
        $(this).closest('tr').remove();  //清空当前行
    }
    $("#file0").change(function(){
        var size = this.files[0].size / 1024;
        var type = this.files[0].type;
        var img_type = (type.substr(type.lastIndexOf("/"))).toLowerCase();
        if(img_type!="/jpg" && img_type!="/gif" && img_type!="/png" && img_type!="/jpeg" || size > 5120) {
            $(".shangchuan").fadeOut();
            setTimeout(function () {
                layer.msg('图片类型错误或超出5M, 请重新选择图片');
            }, 300);
            return false;
        }
        var objUrl = getObjectURL(this.files[0]) ;//获取文件信息
        var formData = new FormData();
        formData.append('file', this.files[0]);
        formData.append('image_path', $('input[name="head"]').val());
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
                    $('input[name="head"]').val(res.url[0]);
                    $("#img0").attr("src", objUrl);
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
    }) ;
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL!=undefined) {
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
    $('.shangchuanSave').click(function () {
        var that = $(this);
        var head_img = $('input[name="head"]').val();
        if(!head_img) {
            layer.msg('请先选择图片'); return false;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method:"POST",
            url:"{!! route("personal.shop.updateTrademark") !!}",
            data:{trade_img: head_img},
            success:function (res) {
                if(res.status == 200) {
                    $(".shangchuan").fadeOut();
                    window.location.reload();
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
    //    点击 店铺头像显示上传表单,再次点击上传表单隐藏
    $(".uploadImg").on('click',function(){
        if($(this).siblings('div').css("display")=="none"){
            $(this).siblings('div').fadeIn();
        }else{
            $(this).siblings('div').fadeOut();
        }
    });
    $('.btn-primary').click(function () {
         var name = $('input[name=name]').val();
         var address = $('input[name=address]').val();
         var code = $('input[name=sub_code]').val();
         if(!name) {
             layer.msg('商铺名称不可为空'); return false;
         }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method:"POST",
            url:"{!! route("personal.shop.update") !!}",
            data:{name: name, address: address, code: code},
            success:function (res) {
                if(res.status == 200) {
                    layer.msg(res.info);
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
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

    /*图片--上传*/
    $("input[name='code']").on('change', function () {
        var that = $(this);
        var file = that[0].files[0];
        var image = $('input[name=sub_code]');
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
