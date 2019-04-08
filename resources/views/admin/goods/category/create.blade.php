@extends('admin.public.plugins')
@section('content')
<div class="weadmin-body">

    <form id="form1" class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">分类选择</label>
            <div class="layui-input-inline">
                <select name="level" id="level" lay-filter="level">
                    <option value="0">顶级分类</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}"> {{ $item->cate_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline" id="subclass">

            </div>
            <div class="layui-form-mid layui-word-aux">
                二级分类可添加分类属性， 供前台商户选择
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text"
                       name="cate_name"
                       lay-verify="required"
                       jq-error="请输入分类名称"
                       placeholder="请输入分类名称"
                       autocomplete="off"
                       class="layui-input ">
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
        <div class="layui-form-item" id="attribute" style="display: none">
            <label class="layui-form-label">分类属性</label>
            <div class="layui-input-inline">
                <input type="text"
                       placeholder="分类属性名, 例如：尺寸"
                       autocomplete="off"
                       class="layui-input" id="attribute_name">
            </div>
            <div class="layui-input-inline">
                <input type="text"
                        placeholder="分类属性值, 例如：x, xl, xxl"
                        autocomplete="off"
                        class="layui-input" id="attribute_value">
            </div>
            <div class="layui-input-inline">
                <div class="layui-btn-group">
                    <span class="layui-btn layui-btn-sm" onclick="add_attribute(this)">
                        <i class="layui-icon"></i>
                    </span>
                </div>
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
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var tip_tis = '该类不选, 则为二级分类';
    layui.use(['jquery','form', 'layer'], function() {
        var $ = layui.jquery,
            form = layui.form,
            layer = layui.layer;
        //监听提交
        form.on('submit(add)', function(data) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('backstage.category.add') !!}",
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
        //联动
        form.on('select(level)', function (text) {
            var value = text.value;
            if(value == 0) {
               $('#attribute').hide();
               $('#subclass').html('');
               return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"get",
                url:"{!! route('backstage.category.select') !!}",
                data:{'id': value},
                success:function (res) {
                    if(res.status == 200) {
                        $('#subclass').html('');
                        var list = '<select name="level" lay-filter="attribute"> <option value="'+value+'">'+tip_tis+'</option>';
                        var length = res.data.length;
                        for (var i = 0; i < length; i++) {
                            list += '<option value="'+res.data[i]['id']+'"> '+res.data[i]['cate_name']+'</option>';
                        }
                        list += '</select>';
                        $('#subclass').append(list);
                        $('#attribute').show();
                        form.render('select');
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
        });
        //关闭分类属性
        form.on('select(attribute)', function (text) {
            if($(this).text() == tip_tis){
                $('#attribute').show();
                return false;
            }
            $('#attribute').hide();
        });
        //添加属性栏，同时清空原有属性栏属性
        window.add_attribute = function (obj) {
            var name = $('#attribute_name').val(), value = $('#attribute_value').val();
            if(name =='' && value =='') {
                layer.msg('请输入属性名和属性值');return;
            }
            var htm_list = '<div class="layui-form-item"><label class="layui-form-label"></label>';
                htm_list += '<div class="layui-input-inline"><input type="text" name="attribute['+name+']" autocomplete="off" class="layui-input" value="'+name+'"></div>';
                htm_list += '<div class="layui-input-inline"><input type="text" name="attribute['+name+']" autocomplete="off" class="layui-input" value="'+value+'"></div>';
                htm_list += '<div class="layui-input-inline"><div class="layui-btn-group"><span class="layui-btn layui-btn-sm" onclick="deletes(this)"><i class="layui-icon"></i></span></div></div>';
                htm_list += '</div>';
            $('#attribute_name').val(''); $('#attribute_value').val('');
            $('#attribute').append(htm_list);
        };
        //删除属性栏
        window.deletes = function (obj) {
            $(obj).parent().parent().parent().remove();
        }
    });
</script>
@endsection
