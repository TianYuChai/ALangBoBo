@include('admin.public.head')
<section style="margin-top: -3%;">
    <div class="Hui-admin-article">
        <nav class="breadcrumb" style="background-color:#fff;padding: 0 24px">
            首页
            <span class="c-gray en">/</span>
            会员管理
            <span class="c-gray en">/</span>
            会员列表
        </nav>
        <article class="Hui-admin-content clearfix">
            <div class="panel">
                <div class="panel-body">
                    <div class="text-c"> 日期范围：
                        <input type="text" id="search-datetime-start" class="input-text datetimepicker-input" style="width:120px;">
                        -
                        <input type="text" id="search-datetime-end" class="input-text datetimepicker-input" style="width:120px;">
                        <input type="text" class="input-text" style="width:250px" placeholder="输入手机号码进行搜索" id="" name="">
                        <span class="select-box" style="width:150px">
                            <select class="select" name="brandclass" size="1">
                                <option value="" selected>请选择商户类别</option>
                                @foreach($category as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="select-box" style="width:150px">
                            <select class="select" name="brandclass" size="1">
                                <option value="" selected>请选择账户状态</option>
                                @foreach($status as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </span>
                        <button type="submit" class="btn btn-success radius" id="" name="">
                            <i class="Hui-iconfont">&#xe665;</i> 搜用户
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel mt-20">
                <div class="panel-body">
                    <div class="clearfix">
                                <span class="f-l">
                                    <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                                </span>
                        <span class="f-r">当前用户数：<strong>{{ $user_count }}</strong> 条</span>
                    </div>
                    <div class="clearfix mt-20">
                        <table class="table table-border table-bordered table-hover table-bg table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="25">
                                    <input type="checkbox" name="" value="">
                                </th>
                                <th width="100">账户名</th>
                                <th width="80">账户类别</th>
                                <th width="100">真实姓名</th>
                                <th width="100">手机号码</th>
                                <th width="130">加入时间</th>
                                <th width="70">状态</th>
                                <th width="100">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr class="text-c">
                                        <td>
                                            <input type="checkbox" value="{{ $item->id }}" name="">
                                        </td>
                                        <td>
                                            <u style="cursor:pointer" class="text-primary"
                                               onclick="member_show('张三','member-show.html','10001','360','400')">
                                                {{ $item->account }}
                                            </u>
                                        </td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td class="td-status">
                                            <span class="label label-success radius">{{ $item->status_name }}</span>
                                        </td>
                                        <td class="td-manage">
                                            <a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用">
                                                <i class="Hui-iconfont">&#xe631;</i>
                                            </a>
                                            <a title="编辑" href="javascript:;" onclick="member_edit('编辑','member-add.html','4','','510')" class="ml-5" style="text-decoration:none">
                                                <i class="Hui-iconfont">&#xe6df;</i>
                                            </a>
                                            <a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','change-password.html','10001','600','270')" href="javascript:;" title="修改密码">
                                                <i class="Hui-iconfont">&#xe63f;</i>
                                            </a>
                                            <a title="删除" href="javascript:;" onclick="member_del(this,'1')" class="ml-5" style="text-decoration:none">
                                                <i class="Hui-iconfont">&#xe6e2;</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           @include('admin.public.page')
        </article>
    </div>
</section>
@include('admin.public.inject')
<script type="text/javascript">
    $(function(){
        runDatetimePicker();
    });
</script>
