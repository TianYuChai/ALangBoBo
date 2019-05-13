@extends('admin.public.plugins')
@section('content')
    <div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">会员管理</a>
        <a href="javascript:void(0);"> <cite>会员注销列表</cite></a>
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
                <div class="layui-inline">
                    <input type="text" name="account" placeholder="请输入账号"
                           autocomplete="off"
                           class="layui-input"
                           value="{{ Input::get('account', '') }}"/>
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
            <span class="fr" style="line-height:40px">注册会员：{{ $data['cancel_count'] }} 位</span>
        </div>
        <table class="layui-table" id="memberList">
            <thead>
            <tr>
                <th>账户名</th>
                <th>备注</th>
                <th>申请时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>
                        {{ $item->user->account }}
                    </td>
                    <td>该用户申请注销账号</td>
                    <td>{{ $item->created_at }}</td>
                    <td class="td-manage">
                        <a title="查看"
                           onclick="WeAdminShow('查看','{{ route('backstage.member.see', ['id' => $item->uid]) }}')"
                           href="javascript:void(0);">
                            <i class="layui-icon">&#xe63c;</i>
                        </a>
                        <a title="同意" onclick="member_sealup(this,'{{ route('backstage.cancel.agree', ['id' => $item->id]) }}')" href="javascript:void(0);">
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
            /*用户-停用*/
            window.member_sealup = function (obj, url) {
                layer.confirm('确认同意申请吗？', function(index) {
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
