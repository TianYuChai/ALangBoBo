@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">黑名单管理</a>
        <a href="javascript:void(0);"> <cite>黑名单列表</cite></a>
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
            <button class="layui-btn layui-btn-danger" style="background-color:#F8F2F0">
                {{--<i class="layui-icon layui-icon-delete"></i>批量封停--}}
            </button>
            <span class="fr" style="line-height:40px">申请数量：{{ $data['black_count'] }} </span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>申请人</th>
                <th>被举报人</th>
                <th>举报原因</th>
                <th>举报类型</th>
                <th>举报时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>{{ $item->user_name }}</td>
                    <td>{{ $item->gname }}</td>
                    <td>
                        {{ $item->why }}
                    </td>
                    <td>
                        {{ $item->type_name }}
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->status_name }}</td>
                    <td class="td-manage">
                        @if($item->status == 0)
                            <a onclick="black_stop(this,'{{ route('backstage.blackList.store', ['id' => $item->id]) }}')"
                               href="javascript:void(0);" title="确认">
                                <i class="layui-icon layui-icon-download-circle"></i>
                            </a>
                        @endif
                        <a title="不予通过" onclick="goods_sealup(this,'{{ route('backstage.blackList.del', ['id' => $item->id]) }}')" href="javascript:void(0);">
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
            /*用户*/
            window.goods_sealup = function (obj, url) {
                layer.confirm('确认该用户无相关违法？', function(index) {
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
            /*用户-启用*/
            window.black_stop = function (obj, url) {
                layer.confirm('确认要禁止该用户吗?', function(index) {
                    layer.prompt({title: '输入天数，并确认', formType: 2}, function(text, index){
                        if(isNaN(text)) {
                            layer.msg('请填入数字'); return false;
                        }
                        layer.close(index);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            method:"post",
                            url:url,
                            data:{content: text},
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
                })
            };
        })
    </script>
@endsection
