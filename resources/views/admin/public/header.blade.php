<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a href="{{ route('backstage.member.index') }}">
            阿郎博波-商务管理中心
        </a>
    </div>
    <div class="left_open">
        <!-- <i title="展开左侧栏" class="iconfont">&#xe699;</i> -->
        <i title="展开左侧栏" class="layui-icon layui-icon-shrink-right"></i>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:void(0);">{{ auth()->guard('backstage')->user()->nickname }}</a>
            <dl class="layui-nav-child">
                <dd><a class="loginout" href="{{ route('backstage.login.out') }}">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index">
            <a href="/">前台首页</a>
        </li>
    </ul>
</div>
<!-- 顶部结束 -->
