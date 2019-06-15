@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">百录倩影管理</a>
        <a href="javascript:void(0);"> <cite>百录倩影列表</cite></a>
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
                <div class="layui-input-inline">
                    <select name="status" lay-search="">
                        <option value="">请选择状态</option>
                        @foreach(\App\Http\Models\home\demandModel::$_STATUS as $key => $status)
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

            </button>
            <span class="fr" style="line-height:40px">百录倩影数量：{{ $items->count() }} </span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>名称</th>
                <th>发布人</th>
                <th>价格</th>
                <th>状态</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr data-id="{{ $item->id }}">
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->user->account }}</td>
                    <td>
                        {{ $item->moneys }}
                    </td>
                    <td>
                        {{ $item->status_name }}
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td class="td-manage">
                        <a title="查看"
                           onclick="WeAdminShow('查看','{{ route('backstage.demand.show', ['id' => $item->id]) }}')"
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
