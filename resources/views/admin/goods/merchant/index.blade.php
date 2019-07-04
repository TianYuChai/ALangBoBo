@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">店铺管理</a>
        <a href="javascript:void(0);"> <cite>店铺列表</cite></a>
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
                    <input type="text" name="account" placeholder="请输入用户账号"
                           autocomplete="off" class="layui-input"
                           value="{{ Input::get('account', '') }}" />
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="shop_name" placeholder="请输入店铺名称"
                           autocomplete="off" class="layui-input"
                           value="{{ Input::get('shop_name', '') }}" />
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
            <span class="fr" style="line-height:40px">店铺数量：{{ $data['merchant_count'] }} </span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>用户名称</th>
                <th>商铺名称</th>
                <th>商品类别</th>
                <th>商铺编号</th>
                <th>店铺总订单数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>{{ $item->user->account }}</td>
                    <td>{{ $item->shop_name }}</td>
                    <td>
                        @if($item->category != 0 && $item->status == 1)
                            <div class="layui-input-inline">
                                <select name="level" class="distinguish" lay-filter="level"
                                        data-action="{{ route('backstage.member.updateDistinguish', ['id' => $item->id]) }}">
                                    <option value="0" {{ $item->distinguish == 0 ? 'selected' : '' }}>普通商户</option>
                                    <option value="1" {{ $item->distinguish == 1 ? 'selected' : '' }}>加盟店</option>
                                    <option value="2" {{ $item->distinguish == 2 ? 'selected' : '' }}>直营店</option>
                                </select>
                            </div>
                        @else
                            无法操作
                        @endif
                    </td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->order->count() }}</td>
                    <td class="td-manage">
                        <a title="查看"
                           onclick="WeAdminShow('查看','{{ route('backstage.merchant.show', ['id' => $item->id]) }}')"
                           href="javascript:void(0);">
                            <i class="layui-icon">&#xe63c;</i>
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
            $('.distinguish').change(function () {
                var distinguish_id = $(this).val();
                var url = $(this).data('action');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"post",
                    url:url,
                    data:{distinguish_id: distinguish_id},
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
    </script>
@endsection
