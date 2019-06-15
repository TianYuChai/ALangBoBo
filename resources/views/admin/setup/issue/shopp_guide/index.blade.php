@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">底部内容管理</a>
        <a href="javascript:void(0);"> <cite>底部内容列表</cite></a>
    </span>
        <a class="layui-btn layui-btn-sm" style="margin-top:3px;float:right"
           href="javascript:location.replace(location.href);"
           title="刷新">
            <i class="layui-icon layui-icon-refresh"></i>
        </a>
    </div>
    <div class="weadmin-body">
        <div class="layui-row">
        </div>
        <div class="weadmin-block">
            <button class="layui-btn" onclick="WeAdminShow('添加','{{ route("backstage.shopp_guide.duitecteate") }}')">
                <i class="layui-icon layui-icon-add-circle-fine"></i>添加
            </button>
            <span class="fr" style="line-height:40px"></span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>类别</th>
                <th>标题</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr data-id="{{ $item->id }}">
                    <td>
                        {{ \App\Http\Models\setup\shoppDuiteModel::$_CATEGORY[$item->category_id] }}
                    </td>
                    <td>
                        {{ $item->title }}
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td class="td-manage">
                        <a onclick="WeAdminShow('修改信息', '{{ route('backstage.shopp_guide.duiteedit', ['id' => $item->id]) }}')"
                           title="修改" href="javascript:void(0);">
                            <i class="layui-icon layui-icon-util"></i>
                        </a>
                        <a title="删除" onclick="banner_del(this,'{{ route('backstage.shopp_guide.duitedel', ['id' => $item->id]) }}')"
                           href="javascript:void(0);">
                            <i class="layui-icon layui-icon-delete"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        layui.use(['laydate', 'layer', 'jquery'], function() {
            var laydate = layui.laydate,
                layer = layui.layer,
                $ = layui.jquery;
            laydate.render({
                elem: '#time'
                ,type: 'datetime'
                ,range: true
            });
            /*图片-放大-展示*/
            window.imgshow = function (obj, url) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: ['920px', '650px'],
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: '<img src="'+url+'">'
                });
            };
            /*banner-操作*/
            window.banner_stop = function (obj, url) {
                layer.confirm('是否进行操作?', function(index) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"get",
                        url:url,
                        data:"",
                        success:function (res) {
                            if(res.status == 200) {
                                layer.msg(res.info);
                                setTimeout(function () {
                                    window.location.reload();
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
                })
            };
            window.banner_del = function (obj, url) {
                layer.confirm('是否进行删除操作?', function(index) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"get",
                        url:url,
                        data:"",
                        success:function (res) {
                            if(res.status == 200) {
                                layer.msg(res.info);
                                setTimeout(function () {
                                    window.location.reload();
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
                })
            }
        })
    </script>
@endsection
