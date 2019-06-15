@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">兼职管理</a>
        <a href="javascript:void(0);"> <cite>兼职列表</cite></a>
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
                    <input type="text" name="account_name" placeholder="请输入用户账号"
                           autocomplete="off" class="layui-input"
                           value="{{ Input::get('account_name', '') }}" />
                </div>
                <button class="layui-btn" lay-submit="" lay-filter="sreach">
                    <i class="layui-icon layui-icon-search"></i>
                </button>
            </form>
        </div>
        <div class="weadmin-block">
            <button class="layui-btn layui-btn-danger" style="background-color:#F8F2F0">

            </button>
            <span class="fr" style="line-height:40px">兼职数量：{{ $items->count() }} </span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>兼职名称</th>
                <th>发布人</th>
                <th>公司名称</th>
                <th>兼职类别</th>
                <th>价格</th>
                <th>投递人数</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr data-id="{{ $item->id }}">
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->merchant->user->account }}</td>
                    <td>
                        {{ $item->merchant->shop_name }}
                    </td>
                    <td>
                        {{ $item->category_name }}
                    </td>
                    <td>
                        {{ $item->moneys }}
                    </td>
                    <td>
                        {{ $item->send->count() }}
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td class="td-manage">
                        <a title="查看"
                           onclick="WeAdminShow('查看','{{ route('backstage.parttime.show', ['id' => $item->id]) }}')"
                           href="javascript:void(0);">
                            <i class="layui-icon">&#xe63c;</i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="page">
            {!! $items->links() !!}
        </div>
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
        })
    </script>
@endsection
