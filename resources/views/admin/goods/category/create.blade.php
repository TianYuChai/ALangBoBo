@extends('admin.public.plugins')
@section('content')
<div class="weadmin-body">

    <form id="form1" class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">联动选择框</label>
            <div class="layui-input-inline">
                <select name="quiz1">
                    <option value="">父类</option>
                    <option value="浙江" selected="">浙江省</option>
                    <option value="你的工号">江西省</option>
                    <option value="你最喜欢的老师">福建省</option>
                </select>
            </div>
            <div class="layui-input-inline">
                {{--<select name="quiz2">--}}
                    {{--<option value="">请选择市</option>--}}
                    {{--<option value="杭州">杭州</option>--}}
                    {{--<option disabled="" value="宁波">宁波</option>--}}
                    {{--<option value="温州">温州</option>--}}
                    {{--<option value="温州">台州</option>--}}
                    {{--<option value="温州">绍兴</option>--}}
                {{--</select>--}}
            </div>
            <div class="layui-input-inline">
                {{--<select name="quiz3">--}}
                    {{--<option value="">请选择县/区</option>--}}
                    {{--<option value="西湖区">西湖区</option>--}}
                    {{--<option value="余杭区">余杭区</option>--}}
                    {{--<option value="拱墅区">临安市</option>--}}
                {{--</select>--}}
            </div>
            <div class="layui-form-mid layui-word-aux">

            </div>
        </div>
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">父级分类</label>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<select name="pid" id="pid-select" lay-verify="required" lay-filter="pid-select">--}}
                    {{--<option value="0" data-level="0">顶级分类</option>--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" jq-error="请输入分类名称" placeholder="请输入分类名称" autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="order" lay-verify="number" value="100" jq-error="排序必须为数字" placeholder="分类排序" autocomplete="off" class="layui-input ">
            </div>
        </div>
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">状态</label>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<input type="radio" name="switch" title="启用" value="1" checked />--}}
                {{--<input type="radio" name="switch" title="禁用" value="0" />--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
                {{--<button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            </div>
        </div>
        <input type="hidden" name="level" value="0" />
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript">

    layui.use(['jquery','form', 'layer'], function() {
        var $ = layui.jquery,
            form = layui.form,
            layer = layui.layer;

        //监听提交
        form.on('submit(add)', function(data) {
            console.log(data.field);
            //发异步，把数据提交给php
            layer.alert("增加成功", {
                icon: 6
            }, function() {
                // 获得frame索引
                var index = parent.layer.getFrameIndex(window.name);
                //关闭当前frame
                parent.layer.close(index);
            });
            return false;
        });

        //遍历select option
        $(document).ready(function(){
            $("#pid-select option").each(function (text){
                var level = $(this).attr('data-level');
                var text = $(this).text();
                console.log(text);
                if(level>0){
                    text = "├　"+ text;
                    for(var i=0;i<level;i++){
                        text ="　　"+ text;　//js中连续显示多个空格，需要使用全角的空格
                        //console.log(i+"text:"+text);
                    }
                }
                $(this).text(text);

            });
            form.render('select'); //刷新select选择框渲染
        });

    });
</script>
@endsection
