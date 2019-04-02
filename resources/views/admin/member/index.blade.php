@extends('admin.public.plugins')
@section('content')
<div class="weadmin-nav">
    <span class="layui-breadcrumb">
        <a href="javascript:void(0);">首页</a> <a href="javascript:void(0);">会员管理</a>
        <a href="javascript:void(0);"> <cite>会员列表</cite></a>
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
            会员搜索：
            <div class="layui-input-inline">
                <input class="layui-input"
                       id="time"
                       type="text"
                       placeholder="{{ $data['select_section_time'] ?? ' - ' }}"
                       name="section_time"
                >
            </div>
            <div class="layui-inline">
                <input type="text" name="account" placeholder="请输入账号" autocomplete="off" class="layui-input"
                    {{ empty($data['select_account']) ?? '' }} />
            </div>
            <div class="layui-input-inline">
                <select name="category" lay-search="">
                    <option value="">请选择账户类别</option>
                    @foreach($data['category'] as $key => $value)
                        <option value="{{ $key }}"
                            {{ empty($data['select_category']) ?
                            $data['select_category'] == "0" ?
                            $data['select_category'] == $key ? "selected" : "":""
                             : $data['select_category'] == $key ? "selected" : "" }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="status" lay-search="">
                    <option value="">请选择账户状态</option>
                    @foreach($data['status'] as $key => $value)
                        <option value="{{ $key }}"
                            {{ empty($data['select_status']) ?
                                $data['select_status'] == "0" ?
                                $data['select_status'] == $key ? "selected" : "":""
                             : $data['select_status'] == $key ? "selected" : "" }}
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <button class="layui-btn" lay-submit="" lay-filter="sreach">
                <i class="layui-icon layui-icon-search"></i>
            </button>
        </form>
    </div>
    <div class="weadmin-block">
        <button class="layui-btn layui-btn-danger" onclick="delAll()">
            <i class="layui-icon layui-icon-delete"></i>批量删除
        </button>
        <button class="layui-btn" onclick="WeAdminShow('添加用户','./add.html',600,400)">
            <i class="layui-icon layui-icon-add-circle-fine"></i>添加
        </button>
        <span class="fr" style="line-height:40px">注册会员：{{ $data['user_count'] }} 位</span>
    </div>
    <table class="layui-table" id="memberList">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon">&#xe605;</i>
                </div>
            </th>
            <th>账户名</th>
            <th>账户类别</th>
            <th>真实姓名</th>
            <th>手机号码</th>
            <th>注册时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @foreach($data['items'] as $item)
                <tr data-id="{{ $item->id }}">
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id="{{ $item->id }}">
                            <i class="layui-icon">&#xe605;</i>
                        </div>
                    </td>
                    <td>{{ $item->account }}</td>
                    <td>{{ $item->category_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->number }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td class="td-status">
                        @if($item->status == 0)
                            {{ $item->status_name }}
                        @elseif($item->status == 1)
                            <span class="layui-btn layui-btn-normal layui-btn-xs">
                                {{ $item->status_name }}
                            </span>
                        @elseif(in_array($item->status, [2, 3]))
                            <span class="layui-btn layui-btn-normal layui-btn-xs layui-btn-disabled">
                                {{ $item->status_name }}
                            </span>
                        @endif
                    </td>
                    <td class="td-manage">
                        @if($item->status == 0)
                            @if(!empty($item->registerauditing))
                                <span class="layui-btn layui-btn-normal layui-btn-xs layui-btn-disabled">
                                    已审核，等待用户重新提交
                                </span>
                            @else
                                <a title="过审"
                                   onclick="member_adopt(this,'{{ route('backstage.member.adopt', ['id' => $item->id]) }}')"
                                   href="javascript:void(0);"
                                   class="layui-btn layui-btn-xs">
                                    过审
                                </a>
                                <a title="驳回"
                                   onclick="member_reject(this,'{{ route('backstage.member.reject', ['id' => $item->id]) }}')"
                                   href="javascript:void(0);"
                                   class="layui-btn layui-btn-xs">
                                    驳回
                                </a>
                            @endif
                        @elseif($item->status == 1)
                            {{--<span class="layui-btn layui-btn-normal layui-btn-xs">--}}
                                {{--{{ $item->status_name }}--}}
                            {{--</span>--}}
                        @elseif(in_array($item->status, [2, 3]))
                            {{--<span class="layui-btn layui-btn-normal layui-btn-xs layui-btn-disabled">--}}
                                {{--{{ $item->status_name }}--}}
                            {{--</span>--}}
                        @endif
                        <a onclick="change_password(this, '{{ route('backstage.member.edit_pass', ['id' => $item->id]) }}')"
                           title="修改密码" href="javascript:void(0);">
                            <i class="layui-icon layui-icon-util"></i>
                        </a>
                        {{--<a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">--}}
                            {{--<i class="layui-icon layui-icon-delete"></i>--}}
                        {{--</a>--}}
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

            /*用户-过审*/
            window.member_adopt = function(obj, url)
            {
                layer.confirm('是否确认通过审核?', function(index) {
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
            /*用户-驳回*/
            window.member_reject = function(obj, url) {
                layer.prompt({title: '请输入驳回理由, 方便用户进行修改!', formType: 2}, function(text, index){
                    layer.close(index);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"post",
                        url:url,
                        data:{'reject_reason': text},
                        success:function (res) {
                            if(res.status == 200) {
                                layer.msg(res.info);
                                setTimeout(function () {
                                    window.location.href = res.url;
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
            /*用户-更改密码*/
            window.change_password = function (obj, url) {
                layer.prompt({title: '请输入新的密码, 密码长度为6-12', formType: 3}, function(text, index){
                    layer.close(index);
                    if(/.*[\u4e00-\u9fa5]+.*$/.test(text)) {
                        layer.msg('不可使用中文作为账户密码!');return;
                    }
                    if(text.length < 6 || text.length > 12) {
                        layer.msg('密码长度需为6-12个字符');return;
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method:"post",
                        url:url,
                        data:{'pass': text},
                        success:function (res) {
                            if(res.status == 200) {
                                layer.msg(res.info);
                                setTimeout(function () {
                                    window.location.href = res.url;
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
            /*用户-停用*/
            window.member_stop = function (obj, id) {
                layer.confirm('确认要停用吗？', function(index) {
                    if($(obj).attr('title') == '启用') {
                        //发异步把用户状态进行更改
                        $(obj).attr('title', '停用');
                        $(obj).find('i').html('&#xe62f;');

                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                        layer.msg('已停用!', {
                            icon: 5,
                            time: 1000
                        });
                    } else {
                        $(obj).attr('title', '启用')
                        $(obj).find('i').html('&#xe601;');
                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                        layer.msg('已启用!', {
                            icon: 5,
                            time: 1000
                        });
                    }
                });
            }
        })
    </script>
@endsection
