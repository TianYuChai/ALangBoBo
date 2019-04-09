@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
			<span class="layui-breadcrumb">
		        <a href="javascript:void(0);">首页</a>
		        <a href="javascript:void(0);">商品管理</a>
		        <a><cite>分类管理</cite></a>
		    </span>
        <a class="layui-btn layui-btn-sm" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="weadmin-body">
        <div class="weadmin-block">
            <button class="layui-btn" id="expand">全部展开</button>
            <button class="layui-btn" id="collapse">全部收起</button>
            <button class="layui-btn" onclick="WeAdminShow('添加分类','{{ route('backstage.category.create') }}')">
                <i class="layui-icon"></i>添加</button>
            {{--<span class="fr" style="line-height:40px">共有数据：66 条</span>--}}
        </div>

        <div id="demo"></div>
    </div>
@endsection
@section('inject')
    @parent
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
@endsection
@section('script')
    <script type="text/javascript">
        layui.extend({
            admin: "{/}{{ asset('admin/static/js/admin') }}"
        });
        //自定义的render渲染输出多列表格
        var layout = [{
            name: '菜单名称',
            treeNodes: true,
            headerClass: 'value_col',
            colClass: 'value_col',
            style: 'width: 60%'
        },
            {
                name: '状态',
                headerClass: 'td-status',
                colClass: 'td-status',
                style: 'width: 10%',
                render: function(row) {
                    return '<span class="layui-btn layui-btn-normal layui-btn-xs">'+row.status_name+'</span>';
                }
            },
            {
                name: '操作',
                headerClass: 'td-manage',
                colClass: 'td-manage',
                style: 'width: 20%',
                render: function(row) {
                    return '<a onclick="category_stop(this, \'{{ route('') }}\')" href="javascript:;" title="启用"><i class="layui-icon">&#xe601;</i></a>' +
                        '<a title="添加子类" onclick="WeAdminShow(\'添加\',\'./category-add.html\')" href="javascript:;"><i class="layui-icon">&#xe654;</i></a>' +
                        '<a title="编辑" onclick="WeAdminShow(\'编辑\',\'./category-edit.html\')" href="javascript:;"><i class="layui-icon">&#xe642;</i></a>' +
                        '<a title="删除" onclick="del(' + row.id + ')" href="javascript:;">\<i class="layui-icon">&#xe640;</i></a>';
                    //return '<a class="layui-btn layui-btn-danger layui-btn-mini" onclick="del(' + row.id + ')"><i class="layui-icon">&#xe640;</i> 删除</a>'; //列渲染
                }
            },
        ];
        layui.use(['treeGird', 'jquery', 'admin', 'layer'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                admin = layui.admin,
                treeGird = layui.treeGird;
            var tree1 = layui.treeGird({
                elem: '#demo', //传入元素选择器
                spreadable: false, //设置是否全展开，默认不展开
                nodes: {!! $data !!},
                layout: layout
            });
            $('#collapse').on('click', function() {
                layui.collapse(tree1);
            });

            $('#expand').on('click', function() {
                layui.expand(tree1);
            });
        });
    </script>
@endsection
