@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-body">
        <form id="form1" class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">链接地址</label>
                    <div class="layui-input-inline">
                        <input name="url"
                               class="layui-input"
                               type="tel"
                               autocomplete="off"
                               lay-verify="required|url" placeholder="用户点击横幅跳转地址">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上下架时间</label>
                <div class="layui-input-inline">
                    <input class="layui-input"
                           id="time"
                           type="text"
                           placeholder="请选择时间"
                           name="section_time"
                           autocomplete="off"
                           lay-verify="section_time"
                    >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="text"
                           name="sort"
                           lay-verify="number"
                           value="100"
                           jq-error="排序必须为数字"
                           placeholder="分类排序"
                           autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">横幅图</label>
                <div class="layui-upload">
                    <button class="layui-btn" id="banner" type="button">上传图片</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="banner_image">
                            <input type="hidden" name="banner_image_url" lay-verify="image_url">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        layui.use(['jquery','form', 'layer', 'laydate', 'upload'], function() {
            var $ = layui.jquery,
                form = layui.form,
                layer = layui.layer,
                laydate = layui.laydate,
                upload = layui.upload;
            laydate.render({
                elem: '#time'
                ,range: true
            });
            form.verify({
                section_time: function(value) {
                    if(!value){
                        return "请选择上下架时间";
                    }
                },
                image_url: function (value) {
                    if(!value) {
                        return "请上传轮播图";
                    }
                }
            });
            //监听提交
            form.on('submit(add)', function(data) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{!! route('backstage.banner.store') !!}",
                    data:data.field,
                    success:function (res) {
                        if(res.status == 200) {
                            layer.msg(res.info);
                            setTimeout(function () {
                                window.location.href = res.url;
                            }, 1000)
                        }
                    },
                    error:function (XMLHttpRequest) {
                        //返回提示信息
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    }
                });
                return false;
            });
            //图片上传
            var uploadInst = upload.render({
                elem: '#banner'
                ,url: '{{ route("file.upload") }}'
                ,headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
                ,exts: 'gif|jpg|jpeg|png'
                ,data: {'type' : 'layui', 'image_path' : function () {
                        return $('input[name=banner_image_url]').val();
                    }}
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#banner_image').attr('src', result); //图片链接（base64）
                    });
                }
                ,done: function(res){
                    if(!res.url) {
                        layer.msg(res.info);return;
                    }
                    //上传成功
                    $('input[name=banner_image_url]').val(res.url);
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
    </script>
@endsection
