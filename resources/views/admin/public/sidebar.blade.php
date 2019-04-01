<!--_menu 作为公共模版分离出去-->
<aside class="Hui-admin-aside-wrapper">
    <div class="Hui-admin-logo-wrapper">
        <a class="logo navbar-logo" href="{{ route('backstage.index.index') }}">
            <i class="va-m iconpic global-logo"></i>
            <span class="va-m">H-ui.admin</span>
        </a>
    </div>
    <div class="Hui-admin-menu-dropdown bk_2">
        <dl id="menu-member" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe60d;</i> 会员管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a _href="{{ route('backstage.member.index') }}" title="会员列表">会员列表</a></li>
                    <li><a href="member-del.html" title="删除的会员">删除的会员</a></li>
                    <li><a href="member-record-browse.html" title="浏览记录">浏览记录</a></li>
                    <li><a href="member-record-download.html" title="下载记录">下载记录</a></li>
                    <li><a href="member-record-share.html" title="分享记录">分享记录</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-system" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="system-base.html" title="系统设置">系统设置</a></li>
                    <li><a href="system-category.html" title="栏目管理">栏目管理</a></li>
                    <li><a href="system-data.html" title="数据字典">数据字典</a></li>
                    <li><a href="system-shielding.html" title="屏蔽词">屏蔽词</a></li>
                    <li><a href="system-log.html" title="系统日志">系统日志</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="Hui-admin-aside-mask"></div>
<!--/_menu 作为公共模版分离出去-->
<div class="Hui-admin-dislpayArrow">
    <a href="javascript:void(0);" onClick="displaynavbar(this)">
        <i class="Hui-iconfont Hui-iconfont-left">&#xe6d4;</i>
        <i class="Hui-iconfont Hui-iconfont-right">&#xe6d7;</i>
    </a>
</div>
