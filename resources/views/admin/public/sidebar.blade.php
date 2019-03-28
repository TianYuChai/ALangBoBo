<!--_menu 作为公共模版分离出去-->
<aside class="Hui-admin-aside-wrapper">
    <div class="Hui-admin-logo-wrapper">
        <a class="logo navbar-logo" href="/aboutHui.shtml">
            <i class="va-m iconpic global-logo"></i>
            <span class="va-m">H-ui.admin</span>
        </a>
    </div>
    <div class="Hui-admin-menu-dropdown bk_2">
        <dl id="menu-article" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe616;</i> 资讯管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="article-list.html" title="资讯管理">资讯管理</a></li>
                    <li><a onclick="article_add('添加资讯','article-add.html')" href="javascript:;" title="新增资讯">新增资讯</a></li>
                    <li>
                        <dl class="Hui-menu">
                            <dt class="Hui-menu-title">二级菜单<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
                            <dd class="Hui-menu-item">
                                <ul>
                                    <li><a href="#" title="">三级菜单</a></li>
                                </ul>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe613;</i> 图片管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="picture-list.html" title="图片管理">图片管理</a></li>
                    <li><a onclick="picture_add('添加资讯','picture-add.html')" href="javascript:;" title="图片管理">新增图片</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-product" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe620;</i> 产品管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="product-brand.html" title="品牌管理">品牌管理</a></li>
                    <li><a href="product-category.html" title="分类管理">分类管理</a></li>
                    <li><a href="product-list.html" title="产品管理">产品管理</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-comments" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe622;</i> 评论管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="comment-list.html" title="评论列表">评论列表</a></li>
                    <li><a href="feedback-list.html" title="意见反馈">意见反馈</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-member" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe60d;</i> 会员管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="member-list.html" title="会员列表">会员列表</a></li>
                    <li><a href="member-del.html" title="删除的会员">删除的会员</a></li>


                    <li><a href="member-record-browse.html" title="浏览记录">浏览记录</a></li>
                    <li><a href="member-record-download.html" title="下载记录">下载记录</a></li>
                    <li><a href="member-record-share.html" title="分享记录">分享记录</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="admin-role.html" title="角色管理">角色管理</a></li>
                    <li><a href="admin-permission.html" title="权限管理">权限管理</a></li>
                    <li><a href="admin-list.html" title="管理员列表">管理员列表</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-tongji" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe61a;</i> 系统统计<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="charts-1.html" title="折线图">折线图</a></li>
                    <li><a href="charts-2.html" title="区域图">区域图</a></li>
                    <li><a href="charts-3.html" title="柱状图">柱状图</a></li>
                    <li><a href="charts-4.html" title="饼状图">饼状图</a></li>
                    <li><a href="charts-5.html" title="散点图">散点图</a></li>
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
        <dl id="menu-errorPage" class="Hui-menu">
            <dt class="Hui-menu-title"><i class="Hui-iconfont">&#xe6e0;</i> 异常页面<i class="Hui-iconfont Hui-admin-menu-dropdown-arrow">&#xe6d5;</i></dt>
            <dd class="Hui-menu-item">
                <ul>
                    <li><a href="error-404.html" title="404">404</a></li>
                    <li><a href="error-500.html" title="404">500</a></li>
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
