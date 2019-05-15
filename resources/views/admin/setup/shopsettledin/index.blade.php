@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">系统管理</a>
        <a href="javascript:void(0);"> <cite>入驻费列表</cite></a>
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

            </form>
        </div>
        <div class="weadmin-block">
            <button class="layui-btn" onclick="WeAdminShow('添加入驻费','{{ route("backstage.settled.create") }}')">
                <i class="layui-icon layui-icon-add-circle-fine"></i>添加
            </button>
            <span class="fr" style="line-height:40px">费用条数：{{ $data['count'] }} 位</span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>费用名</th>
                <th>费用金额</th>
                <th>时长</th>
                <th>费用排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>{{ $item->moneys }}</td>
                    <td>{{ $item->duration }} 天</td>
                    <td>{{ $item->sort }}</td>
                    <td class="td-manage">
                        <a title="封停" onclick="member_sealup(this,'{{ route('backstage.settled.del', ['id' => $item->id]) }}')" href="javascript:void(0);">
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
            /*费用-删除*/
            window.member_sealup = function (obj, url) {
                layer.confirm('确认要删除吗？', function(index) {
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
                });
            };
        })
    </script>
@endsection
