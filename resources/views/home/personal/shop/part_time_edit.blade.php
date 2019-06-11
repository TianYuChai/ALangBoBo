@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-兼职管理')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}">
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
            <form class="form-horizontal" id="update_part_time"
                  method="post" action="{{ route('personal.partime.update', ['id' => $item->id]) }}">
                @csrf
                <div class="form-group">
                    <label class="col-sm-2 control-label">兼职名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               name="title" placeholder="请输入兼职名称"
                               autocomplete="off" value="{{ $item->title }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">兼职分类</label>
                    <div class="col-sm-10 goods">
                        <select class="form-control category" name="category">
                            @foreach($goodsCategorys as $goodsMainCategory)
                                <option value="{{ $goodsMainCategory->id }}"
                                    {{ $item->category == $goodsMainCategory->id ? 'selected' : '' }}> {{ $goodsMainCategory->cate_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">薪资计算方式</label>
                    <div class="col-sm-10 goods">
                        <select class="form-control settle" name="settle">
                            @foreach($settle as $key => $value)
                                <option value="{{ $key }}"
                                    {{ $item->settle == $key ? 'selected' : '' }}> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">工作时长</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               name="time" placeholder="请输入工作时长" autocomplete="off" value="{{ $item->time }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputPassword">薪资</label>
                    <div class="input-group" style="width: 250px;margin-left: 165px;">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control money"
                               name="total_price" placeholder="单位：元"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();" autocomplete="off" value="{{ $item->moneys }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputPassword">描述</label>
                    <div class="input-group" style="width: 250px;margin-left: 165px;">
                        <textarea name="describe" id="" cols="30"
                                  rows="5">{{ $item->describe }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">封面图</label>
                    <div class="col-sm-10">
                        <img src="{{ FileUpload::url('image', $item->image) }}"
                             class="img-rounded">
                        <input type="file" id="cover" accept="image/*">
                        <input type="hidden" name="cover_img" value="{{ $item->image }}">
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
        $('.update').click(function () {
            $.each($('#update_part_time').serializeArray(), function (k, val) {
                if(!val['value']) {
                    layer.msg('以上值不可为空'); return false;
                }
            });
            if(!$('.layui-layer-msg').length) {
                $("#update_part_time").ajaxSubmit({
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
    </script>
@endsection
