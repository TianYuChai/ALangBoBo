@extends('admin.public.plugins')
<style>
    #ue-container {
        margin-left: 122px;
    }
    .layui-form-select{
        z-index: 1000;
    }
</style>
@section('content')
    <div class="weadmin-body">
        <form id="form1" class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">分类</label>
                <div class="layui-input-inline" >
                    <select name="category" lay-search="" lay-verify="category">
                        <option value="">请选择分类</option>
                        @foreach(\App\Http\Models\setup\shoppDuiteModel::$_CATEGORY as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">标题</label>
                    <div class="layui-input-inline">
                        <input name="title"
                               class="layui-input"
                               type="tel"
                               autocomplete="off"
                               lay-verify="required" placeholder="用户点击横幅跳转地址">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">内容</label>
                <div class="layui-upload">
                    <script id="ue-container" name="content"  type="text/plain" style="height: 450px;"></script>
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
    <!-- ueditor-mz 配置文件 -->
    <script type="text/javascript" src="{{  asset('home/ueditor/ueditor.config.js') }}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{ asset('home/ueditor/ueditor.all.js') }}"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('ue-container');
        ue.ready(function(){
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
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
                title: function(value) {
                    if(!value){
                        return "请填写标题";
                    }
                },
                category: function (value) {
                    if(!value) {
                        return '请选择分类';
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
                    url:"{!! route('backstage.shopp_guide.duitestore') !!}",
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
        });
    </script>
@endsection
