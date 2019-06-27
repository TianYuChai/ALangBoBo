@extends('admin.public.plugins')
@section('content')
<div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">投诉与建议管理</a>
        <a href="javascript:void(0);"> <cite>投诉与建议列表</cite></a>
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
            <div class="layui-input-inline">
                <select name="status" lay-search="">
                    @foreach(\App\Http\Models\setup\complainModel::$_STATUS as $key => $value)
                        <option value="{{ $key }}" {{ Input::get('status', '') == $key ? 'selected' : '' }}> {{ $value }} </option>
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
        <span class="fr" style="line-height:40px">数量：{{ $data['complain_count'] }} </span>
    </div>
    <table class="layui-table" id="memberList">
        <thead>
        <tr>
            <th>申请人</th>
            <th>被举报人</th>
            <th>举报原因</th>
            <th>申请人类别</th>
            <th>举报时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['items'] as $item)
        <tr data-id="{{ $item->id }}">
            <td>
                @if($item->name == 0)
                    {{ $item->user->account }}
                @else
                    {{ $item->user->merchant->shop_name }}
                @endif
            </td>
            <td>
                @if($item->name == 0)
                    {{ $item->buser->merchant->shop_name }}
                @else
                    {{ $item->buser->account }}
                @endif
            </td>
            <td>
                {{ $item->content }}
            </td>
            <td>
                {{ $item->names }}
            </td>
            <td>{{ $item->created_at }}</td>
            <td>
                {{ $item->status_name }}
            </td>
            <td class="td-manage">
                @if(empty($item->status) && $item->status != '0')
                <a onclick="black_stop(this,'{{ route('backstage.complain.handle', ['id' => $item->id, 'type' => 0]) }}')"
                   href="javascript:void(0);" title="公示">
                    <i class="layui-icon layui-icon-download-circle"></i>
                </a>
                <a title="不公示" onclick="black_stop(this,'{{ route('backstage.complain.handle', ['id' => $item->id, 'type' => 1]) }}')" href="javascript:void(0);">
                    <i class="layui-icon layui-icon-delete"></i>
                </a>
                @else
                    @if($item->status == 0)
                        <a title="不公示" onclick="black_stop(this,'{{ route('backstage.blackList.del', ['id' => $item->id, 'type' => 1]) }}')" href="javascript:void(0);">
                            <i class="layui-icon layui-icon-delete"></i>
                        </a>
                    @else
                        <a onclick="black_stop(this,'{{ route('backstage.blackList.store', ['id' => $item->id, 'type' => 0]) }}')"
                           href="javascript:void(0);" title="公示">
                            <i class="layui-icon layui-icon-download-circle"></i>
                        </a>
                    @endif
                @endif
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
        /*用户-启用*/
        window.black_stop = function (obj, url) {
            layer.confirm('确认要进行此操作吗?', function(index) {
                layer.close(index);
                layer.prompt({title: '输入处理结果，并确认', formType: 2}, function(text, index){
                    layer.close(index);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"post",
                        url:url,
                        data:{result: text},
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
