@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-body">
        <form id="form1" class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-inline">
                        <input name="name"
                               class="layui-input"
                               type="tel"
                               autocomplete="off"
                               lay-verify="required" placeholder="入驻费用的名称">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">入驻金额</label>
                <div class="layui-input-inline">
                    <input class="layui-input"
                           type="text"
                           name="money"
                           autocomplete="off"
                           lay-verify="required|money"
                           placeholder="金额类别：元"
                    >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">时长</label>
                <div class="layui-input-inline">
                    <input class="layui-input"
                           type="text"
                           name="duration"
                           autocomplete="off"
                           lay-verify="required|duration"
                           placeholder="类别：天，例如：名称是月付，对应时长为30"
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
                layer = layui.layer
                ;
            form.verify({
                money: function(value) {
                    if(!value){
                        return "请填写金额";
                    }
                    if(isNaN(value)) {
                        return "请填入数字";
                    }
                },
                duration: function (value) {
                    if(!value) {
                        return '请填入时长';
                    }
                    if(isNaN(value)) {
                        return "请填入数字";
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
                    url:"{!! route('backstage.settled.store') !!}",
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
