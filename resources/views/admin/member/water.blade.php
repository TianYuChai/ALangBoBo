@extends('admin.public.plugins')
@section('content')
    <div class="layui-form">
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>可用金额</th>
                <th>冻结金额</th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $avail }}元</td>
                <td>{{ $frost }}元</td>
            </tr>
            </tbody>
        </table>
    </div>
    <table class="layui-hide" id="test"></table>
@endsection
@section('script')
    <script type="text/javascript">
        layui.use(['layer', 'jquery', 'table'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                table = layui.table;
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
            table.render({
                elem: '#test'
                ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                ,cols: [[
                    {field:'trade_mode_name', title: '充值方式'}
                    ,{field:'money', title: '金额', sort: true}
                    ,{field:'order_id',  title: '订单号'}
                    ,{field:'memo', title: '备注', minWidth: 100} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
                    ,{field:'category_name', title: '充值类别', sort: true}
                    ,{field:'status_name', title: '状态', sort: true}
                    ,{field:'created_at', title: '获取时间', sort: true}
                ]]
                ,data:{!! $items !!}
                ,skin: 'line' //表格风格
                ,even: true
                ,page: true //是否显示分页
                // ,limits: [5, 7, 10]
                ,limit: 20 //每页默认显示的数量
            });
        })
    </script>
@endsection
