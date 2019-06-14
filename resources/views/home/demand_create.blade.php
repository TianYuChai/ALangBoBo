@extends('home.public.subject')
@section('title', '阿朗博波-百录倩影-需求发布')
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
            <form class="form-horizontal" id="add_demand"
                  method="post" action="{{ route('demand.store') }}">
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
            <div class="form-group" style="text-align: right;margin-top: 20px;">
                <button type="button" class="btn btn-primary add">确认修改</button>
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
            if ($('.layui-layer-msg').length) {
                return;
            }
            $("#add_demand").ajaxSubmit({
                success: function (res) {
                    $('body').append(res);
                    $("form").attr("target", "_blank");
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
    </script>
@endsection
