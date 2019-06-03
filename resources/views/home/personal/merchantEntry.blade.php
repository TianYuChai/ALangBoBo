@extends('home.public.subject')
@section('title', '阿朗博波-商家入驻')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_accountCenter.css') }}"/>
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
        img{
            width: 110px;
            height: 100px;
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
                            <a href="{{ route('personal.creditmargin') }}">信用保证金</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.merchant') }}" class="leftNavActive">商家入驻</a>
                        </li>
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
            <div class="shInfoTittle">
                <p>商家入驻</p>
            </div>
            <div class="shInfoDiv">
                <form class="form-horizontal" style="width: 90%; margin-top: 20px;">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">店名</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control"
                                   value="{{ isset($item) ? $item->shop_name : "" }}"
                                   placeholder="请输入店名" id="shopName" name="shopName" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">统一社会信用代码</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control"
                                   value="{{ isset($item) ? $item->credit_code : "" }}"
                                   placeholder="请输入统一社会信用代码" id="shehuiDaima" name="shehuiDaima" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">入驻类别</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="category" id="category">
                                <option value="1" {{ isset($item) ? $item->category == 1 ? "selected" : "" : "" }}>企业商户</option>
                                <option value="2" {{ isset($item) ? $item->category == 2 ? "selected" : "" : "" }}>个人商户</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">身份证正面照</label>
                        <div class="col-sm-2" style="float: left">
                            <img src="{{ isset($item) ? FileUpload::url('image', $item->card_positive)
                             : asset('home/images/img/idImg.png') }}" class="img-rounded">
                            <input type="file" class="file" accept="image/*" data-id="zheng">
                            <input type="hidden" name="zheng" value="{{ isset($item) ? $item->card_positive : "" }}">
                        </div>
                        <label for="inputPassword" class="col-sm-2 control-label">身份证反面照</label>
                        <div class="col-sm-2">
                            <img src="{{ isset($item) ? FileUpload::url('image', $item->card_opposite)
                             : asset('home/images/img/idImg.png') }}" class="img-rounded">
                            <input type="file" class="file" accept="image/*" data-id="fan">
                            <input type="hidden" name="fan" value="{{ isset($item) ? $item->card_opposite : "" }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">人脸识别</label>
                        <div class="col-sm-2">
                            <img src="{{ asset('home/images/img/idImg.png') }}" class="img-rounded personal" id="face">
                            {{--<input type="file" class="file" data-id="yyzz" accept="image/*">--}}
                        </div>
                    </div>
                    <div class="form-group enterprise" {{ isset($item) ? $item->category == 2 ? "hidden" : "" : "" }}>
                        <label for="inputPassword" class="col-sm-2 control-label">营业执照上传</label>
                        <div class="col-sm-2">
                            <img src="{{ isset($item) ? FileUpload::url('image', $item->bus_license)
                             : asset('home/images/img/idImg.png') }}" class="img-rounded">
                            <input type="file" class="file" data-id="yyzz" accept="image/*">
                            <input type="hidden" name="yyzz" value="{{ isset($item) ? $item->bus_license : "" }}">
                        </div>
                        <label for="inputPassword" class="col-sm-2 control-label">美容或理发行业</label>
                        <div class="col-sm-2">
                            <img src="{{ isset($item) ? $item->hairdressing != "" ? FileUpload::url('image', $item->hairdressing) : asset('home/images/img/idImg.png')
                             : asset('home/images/img/idImg.png') }}" class="img-rounded">
                            <input type="file" class="file" data-id="mrlf" accept="image/*">
                            <input type="hidden" name="mrlf" value="{{ isset($item) ? $item->hairdressing : "" }}">
                        </div>
                        <label for="inputPassword" class="col-sm-2 control-label">食品行业证件上传</label>
                        <div class="col-sm-2">
                            <img src="{{ isset($item) ? $item->food_industry != "" ? FileUpload::url('image', $item->food_industry) : asset('home/images/img/idImg.png')
                             : asset('home/images/img/idImg.png') }}" class="img-rounded">
                            <input type="file" class="file" data-id="food" accept="image/*">
                            <input type="hidden" name="food" value="{{ isset($item) ? $item->food_industry : "" }}">
                        </div>
                    </div>
                    <div class="form-group personals" style="margin-left: 10px" {{ isset($item) ? $item->category == 1 ? "hidden" : "" : "hidden" }}>
                        <label for="inputPassword" class="col-sm-2 control-label">个人证件或作品上传</label>
                        <div class="col-sm-2">
                            <img src="{{ isset($item) ? $item->personal != "" ? FileUpload::url('image', $item->personal) : asset('home/images/img/idImg.png')
                             : asset('home/images/img/idImg.png') }}" class="img-rounded">
                            <input type="file" class="file" data-id="zuopin" accept="image/*">
                            <input type="hidden" name="zuopin" value="{{ isset($item) ? $item->personal : "" }}">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 25px;">
                        <label for="inputPassword" class="col-sm-2 control-label">验证码</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   style="width: 15%; float: left"
                                   class="form-control"
                                   placeholder="验证码"
                                   id="verifyCode"
                                   name="verifyCode"
                                   autocomplete="off">
                            <button type="button" class="btn btn-primary verifyBtn" style="margin-left: 5px">获取验证码</button>
                        </div>
                    </div>
                    <div class="form-group" style="text-align:center">
                        <label for="inputPassword" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-success stepBtnActive">提交申请</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
    <script type="text/javascript">
        if("{{ $wther }}") {
            layer.msg('正在审核中, 无法进行操作! <a href="javascript:history.go(-1)">点击此处返回之前页面</a>', {
                icon: 4,
                shade: 0.4,
                time:false //取消自动关闭
            });
        } else {
          if("{{ $register  }}") {
              layer.alert("{!! $register !!}", {
                  icon: 5,
                  title: "提示"
              });
          }
        }
        var category = {!! $category !!};
        var whether = false;
        var required = {shopName: '店名', shehuiDaima: "统一社会信用代码", zheng: '身份证正面照', fan: '身份证反面照', category: '入驻类别'};
        var array = ['name', 'id', 'mobile', 'shopName', 'shehuiDaima', 'zheng', 'fan', 'category'];
        var enter = ['yyzz', 'mrlf', 'food'];
        $('.stepBtnActive').on('click', function () {
            var that = $(this);
            var obj = {};
            var data = $('.form-horizontal').serializeArray();
            if(!whether) {
                layer.msg('请先进行人脸识别');return false;
            }
            $.each(data, function (k, val) {
                if($.inArray(val['name'], array) != -1) {
                    if(!val['value']) {
                        layer.msg(required[val['name']]+ '不可为空');return false;
                    } else {
                        obj[val['name']] = val['value'];
                    }
                }
                if(category == 1) {
                    if($.inArray(val['name'], enter) != -1) {
                        if(val['name'] == 'yyzz' && !val['value']) {
                            layer.msg('请上传营业执照');return false;
                        }
                        obj[val['name']] = val['value'];
                    }
                } else {
                    if(val['name'] == 'zuopin' && !val['value']) {
                        layer.msg('请上传个人证件或作品');return false;
                    }
                    obj[val['name']] = val['value'];
                }
                if(val['name'] == 'verifyCode') {
                    if(!val['value']) {
                        layer.msg('请填写验证码');return false;
                    }
                    if(val['value'].length < 6 || val['value'].length > 6) {
                        layer.msg('验证码错误');return false;
                    }
                    obj[val['name']] = val['value'];
                }
            });
            if(!$('.layui-layer-msg').length) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{!! route('personal.store') !!}",
                    data: obj,
                    success:function (res) {
                        if(res.status == 200) {
                            layer.msg('已提交审核, 取消当前操作! <a href="{!! route("personal.index") !!}">点击此处前往账户中心</a>', {
                                icon: 4,
                                shade: 0.4,
                                time:false //取消自动关闭
                            });
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
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors'];
                            for (var value in errors) {
                                layer.msg(errors[value][0]);return;
                            }
                        }
                    }
                });
            }
        });
        /*验证码*/
        $('.verifyBtn').on('click', function () {
            var that = $(this);
            var mobile = "{!! Auth::guard('web')->user()->number !!}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.shortMessage') !!}",
                data:{mobile: mobile},
                success:function (res) {
                    if(res.status == 200) {
                        layer.msg(res.info);
                        countDown(29, 59);
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
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
        /*倒计时*/
        function countDown(m, s) {
            $('.verifyBtn').attr('disabled','disabled');
            var time = setInterval(function(){
                if(s < 10){
                    $('.verifyBtn').text(m+':0'+s);
                }else{
                    $('.verifyBtn').text(m+':'+s);
                }
                s--;
                if(m == 0 && s < 0) {
                    clearInterval(time);
                    $('.verifyBtn').text('获取验证码');
                    $('.verifyBtn').removeAttr('disabled');
                    return;
                } else if(s < 0){
                    countDown(m-1, 59);
                }
            }, 1000);
        }
        /*图片--上传*/
        $("input[type='file']").on('change', function () {
            var that = $(this);
            var file = that[0].files[0];
            var image = $('input[name='+that.data('id')+']');
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
        /*监听-姓名*/
        $('.name').blur(function() {
            var that = $(this);
            monitor(that, 'name');
        });
        /*监听-提交*/
        function monitor(that, parameter)
        {
            var val = that.val();
            if(!val) {
                return;
            }
            var data = {};
            data[parameter] = val;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.verifivWhetExist') !!}",
                data:data,
                success:function (res) {
                    if(res.status == 200) {
                        $(".stepBtnActive").removeAttr('disabled');
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    $(".stepBtnActive").attr('disabled','disabled');
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
        }
        /*监听类别变动*/
        $('#category').change(function () {
             let that = $(this);
             let val = that.val();
             category = val;
             $('.personals').toggle();
             $('.enterprise').toggle();
        });
        /*调用摄像头*/
        $('#face').click(function () {
            var that = $(this);
            if($('input[name="zheng"]').val() == '') {
                layer.msg('请先上传身份证');return false;
            }
            var constraints = {
                video: {width: 500, height: 500},
                audio: false
            };
            //获得video摄像头区域
            var promise = navigator.mediaDevices.getUserMedia(constraints);
            promise.then(function (MediaStream) {
                layer.alert('请对准摄像头, 五秒后自动拍照', {icon: 6}, function (index) {
                    layer.close(index);
                    that.hide();
                    that.after('<video id="video" width="500" height="300" autoplay></video>' +
                        '<canvas id="canvas" width="450" height="250"></canvas>');
                    var video = document.getElementById("video");
                    video.srcObject = MediaStream;
                    video.play();
                    setTimeout(function () {
                        takePhoto();
                    }, 5000)
                });
            }).catch((err)=>{
                layer.msg(err.name + ': 系统未监测到您的摄像设备, 请先安装摄像设备');
            });
        });
        function takePhoto() {
            //获得Canvas对象
            var video = document.getElementById("video");
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, 500, 250);
            $("#video").hide();
            //处理canvas图片
            // var face_img = canvas.toDataURL().substring(canvas.toDataURL().indexOf(",")+ 1);
            var face_img = dataURLtoFile(canvas.toDataURL('image/png'));
            console.log(face_img);
            var formData = new FormData();
            formData.append('face_img', face_img);
            formData.append('crid_img', $('input[name="zheng"]').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route("index.face") !!}",
                processData: false,
                contentType: false,
                data:formData,
                success:function (res) {
                    if(res.status == 200) {
                        whether = res.info;
                        console.log('人脸识别2: ' + whether);
                        if(!whether) {
                            $('#face').show();
                            $('#canvas').hide();
                            layer.msg('请上传正确且清晰的图片');return false;
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
            });
        }
        //base64转换成file对象
        function dataURLtoFile(dataurl, filename = 'file') {
            var arr = dataurl.split(',');
            var mime = arr[0].match(/:(.*?);/)[1];
            var bstr = atob(arr[1]);
            var n = bstr.length;
            var u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            //转换成file对象
            return new File([u8arr], filename, {type:mime});
            //转换成成blob对象
            //return new Blob([u8arr],{type:mime});
        }
    </script>
@endsection
