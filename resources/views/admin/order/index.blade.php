@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">订单管理</a>
        <a href="javascript:void(0);"> <cite>订单列表</cite></a>
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
                搜索：
                <div class="layui-inline">
                    <input type="hidden" name="s"/>
                </div>
                <div class="layui-inline">
                    <input type="text" name="order_id" placeholder="请输入用户账号"
                           autocomplete="off" class="layui-input"
                           value="{{ Input::get('order_id', '') }}" />
                </div>
                <div class="layui-input-inline">
                    <select name="status" lay-search="">
                        <option value="">请选择订单状态</option>
                        @foreach($data['status'] as $key => $status)
                            <option value="{{ $key }}" {{ Input::get('status', '') == $key ? 'selected':'' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="layui-btn" lay-submit="" lay-filter="sreach">
                    <i class="layui-icon layui-icon-search"></i>
                </button>
            </form>
        </div>
        <div class="weadmin-block">
            <button class="layui-btn layui-btn-danger" style="background-color:#F8F2F0">
                {{--<i class="layui-icon layui-icon-delete"></i>批量封停--}}
            </button>
            {{--<span class="fr" style="line-height:40px">商品数量：{{ $data['goods_count'] }} </span>--}}
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>商铺名称</th>
                <th>购买人</th>
                <th>订单选购类别</th>
                <th>购买时间</th>
                <th>状态</th>
                {{--<th>操作</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>{{ $item->merchant->shop_name }}</td>
                    <td>{{ $item->user->account }}</td>
                    <td>
                        {{ $item->paymethods }}
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        {{ $item->status_name }}
                    </td>
                    {{--<td class="td-manage">--}}
                        {{--<a title="查看"--}}
                           {{--onclick="WeAdminShow('查看','{{ route('backstage.goods.look', ['id' => $item->id]) }}')"--}}
                           {{--href="javascript:void(0);">--}}
                            {{--<i class="layui-icon">&#xe63c;</i>--}}
                        {{--</a>--}}
                        {{--@if($item->status == 0)--}}
                            {{--<a title="下架" onclick="goods_sealup(this,'{{ route('backstage.goods.operstatus', ['id' => $item->id]) }}')" href="javascript:void(0);">--}}
                                {{--<i class="layui-icon layui-icon-delete"></i>--}}
                            {{--</a>--}}
                        {{--@else--}}
                            {{--<a onclick="goods_stop(this,'{{ route('backstage.goods.operstatus', ['id' => $item->id]) }}')" href="javascript:void(0);" title="启用">--}}
                                {{--<i class="layui-icon layui-icon-download-circle"></i>--}}
                            {{--</a>--}}
                        {{--@endif--}}
                    {{--</td>--}}
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
            /*用户-停用*/
            window.goods_sealup = function (obj, url) {
                layer.confirm('确认要下架吗？', function(index) {
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
            window.goods_stop = function (obj, url) {
                layer.confirm('确认要上架吗?', function(index) {
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
        })
    </script>
@endsection
