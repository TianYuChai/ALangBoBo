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
                    var li = '';
                    li += '<a onclick="category_stop(this, \''+row.tip+'\', \''+row.id+'/bannedOperation\')" href="javascript:;" title="禁启用"><i class="layui-icon">&#xe601;</i></a>';
                    li += '<a title="编辑" onclick="WeAdminShow(\'编辑\',\''+row.id+'/edit\')" href="javascript:;"><i class="layui-icon">&#xe642;</i></a>';
                    return li;
                    // '<a title="删除" onclick="del(' + row.id + ')" href="javascript:;">\<i class="layui-icon">&#xe640;</i></a>';
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

            window.category_stop = function (obj, tip, url) {
                layer.confirm('确认要'+tip+'吗？', function(index) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"get",
                        url:url,
                        data:{},
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
            }
        });
    </script>
@endsection
