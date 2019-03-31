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
                <div class="panel-body"发布>
                    <div class="text-c"> 日期范围：
                        <input type="text" id="search-datetime-start" class="input-text datetimepicker-input" style="width:120px;">
                        -
                        <input type="text" id="search-datetime-end" class="input-text datetimepicker-input" style="width:120px;">
                        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
                        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
                    </div>
                </div>
            </div>
            <div class="panel mt-20">
                <div class="panel-body">
                    <div class="clearfix">
                                <span class="f-l">
                                    <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                                    <a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
                                </span>
                        <span class="f-r">共有数据：<strong>88</strong> 条</span>
                    </div>
                    <div class="clearfix mt-20">
                        <table class="table table-border table-bordered table-hover table-bg table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="25"><input type="checkbox" name="" value=""></th>
                                <th width="80">ID</th>
                                <th width="100">用户名</th>
                                <th width="40">性别</th>
                                <th width="90">手机</th>
                                <th width="150">邮箱</th>
                                <th width="">地址</th>
                                <th width="130">加入时间</th>
                                <th width="70">状态</th>
                                <th width="100">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-c">
                                <td><input type="checkbox" value="1" name=""></td>
                                <td>1</td>
                                <td><u style="cursor:pointer" class="text-primary" onclick="member_show('张三','member-show.html','10001','360','400')">张三</u></td>
                                <td>男</td>
                                <td>13000000000</td>
                                <td>admin@mail.com</td>
                                <td class="text-l">北京市 海淀区</td>
                                <td>2014-6-11 11:11:42</td>
                                <td class="td-status"><span class="label label-success radius">已启用</span></td>
                                <td class="td-manage"><a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="member_edit('编辑','member-add.html','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','change-password.html','10001','600','270')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
@include('admin.public.inject')
<script type="text/javascript">
    $(function(){
        runDatetimePicker();
    });
</script>