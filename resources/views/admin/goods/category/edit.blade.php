@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-body">

        <form id="form1" class="layui-form">
            @if(!empty($category))
                <div class="layui-form-item">
                    <label class="layui-form-label">分类展示</label>
                    @foreach($category as $value)
                        <div class="layui-input-inline">
                            <select>
                                <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="layui-form-item">
                <label class="layui-form-label">分类名称</label>
                <div class="layui-input-block">
                    <input type="text"
                           name="cate_name"
                           lay-verify="required"
                           jq-error="请输入分类名称"
                           placeholder="请输入分类名称"
                           autocomplete="off"
                           class="layui-input " value="{{ $item->cate_name }}">
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
                           class="layui-input" value="{{ $item->sort }}">
                </div>
            </div>
            <div class="layui-form-item" id="attribute"
                 style="display: {{ empty($item->attribute->toArray()) ? ( $item->level == 2 ? "block" : "none"): "block" }}">
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
                @foreach($item->attribute as $attribute_value)
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-inline">
                            <input type="text"
                                   autocomplete="off" class="layui-input"
                                   value="{{ $attribute_value->attribute_name }}" disabled="disabled">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text"
                                   autocomplete="off" class="layui-input"
                                   value="{{ $attribute_value->attribute_value }}" disabled="disabled">
                        </div>
                        <div class="layui-input-inline">
                            <div class="layui-btn-group">
                            <span class="layui-btn layui-btn-sm" onclick='deletes(this, "{{ route('backstage.category.bannedAttriStatus', ['id' => $attribute_value->id]) }}")'>
                                <i class="layui-icon"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                    url: "update",
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
            window.deletes = function (obj, url) {
                if(url) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"get",
                        url: url,
                        data:{},
                        success:function (res) {
                            if(res.status == 200) {
                                $(obj).parent().parent().parent().remove();
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
                }
                $(obj).parent().parent().parent().remove();
            }
        });
    </script>
@endsection
