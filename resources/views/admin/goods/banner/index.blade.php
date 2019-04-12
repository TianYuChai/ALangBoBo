@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">横幅管理</a>
        <a href="javascript:void(0);"> <cite>横幅列表</cite></a>
    </span>
        <a class="layui-btn layui-btn-sm" style="margin-top:3px;float:right"
           href="javascript:location.replace(location.href);"
           title="刷新">
            <i class="layui-icon layui-icon-refresh"></i>
        </a>
    </div>
    <div class="weadmin-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 we-search">
                横幅搜索：
                <div class="layui-input-inline">
                    <input class="layui-input"
                           id="time"
                           type="text"
                           placeholder="请选择时间"
                           name="section_time"
                           autocomplete="off"
                           value="{{ empty($data['select_section_time']) ? '' : $data['select_section_time'] }}"
                    >
                </div>
                <button class="layui-btn" lay-submit="" lay-filter="sreach">
                    <i class="layui-icon layui-icon-search"></i>
                </button>
            </form>
        </div>
        <div class="weadmin-block">
            <button class="layui-btn" onclick="WeAdminShow('添加横幅','{{ route("backstage.banner.create") }}')">
                <i class="layui-icon layui-icon-add-circle-fine"></i>添加
            </button>
            <span class="fr" style="line-height:40px">横幅数量：{{ $data['items']->count() }}</span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary">
                        <i class="layui-icon">&#xe605;</i>
                    </div>
                </th>
                <th>链接地址</th>
                <th>图片</th>
                <th>上架时间</th>
                <th>下架时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id="{{ $item->id }}">
                    <i class="layui-icon">&#xe605;</i>
                    </div>
                    </td>
                    <td>
                        <a href="{{ $item->url }}" target="_blank">
                            {{ $item->url }}
                        </a>
                    </td>
                    <td>
                        <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->image_url) }}')">
                            <img class="layui-circle"
                                 src="{{ FileUpload::url('image', $item->image_url) }}">
                        </div>
                    </td>
                    <td>{{ $item->start_time }}</td>
                    <td>{{ $item->end_time }}</td>
                    <td>{{ $item->status_name }}</td>
                    <td class="td-manage">
                        @if($item->status != 2)
                            <a onclick="banner_stop(this,'{{ route('backstage.banner.stateOperation', ['id' => $item->id]) }}')"
                               href="javascript:void(0);"
                               title="{{ $item->status == 0 ? "上架" : "下架"}}">
                                <i class="layui-icon layui-icon-download-circle"></i>
                            </a>
                        @endif
                        <a title="删除" onclick="banner_del(this,'{{ route('backstage.banner.del', ['id' => $item->id]) }}')"
                           href="javascript:void(0);">
                            <i class="layui-icon layui-icon-delete"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.public.page')
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
