<div class="Hui-admin-article">
    <article class="Hui-admin-content clearfix">
        <div class="row-24 clearfix" style="margin-left: -12px; margin-right: -12px;">
            <div class="col-24-xs-24 col-24-sm-12 col-24-md-12 col-24-lg-12 col-24-xl-6" style="padding-left: 12px; padding-right: 12px; margin-bottom: 24px;">
                <div class="panel">
                    <div class="panel-header" style="padding:15px 24px;font-weight: 400;color:#999;">总销售额：</div>
                    <div class="panel-body" style="padding:0 24px;">
                        <div class="c-primary" style="font-size: 30px;line-height: 38px;padding-bottom: 24px;">
                            &yen; 9,999,999
                        </div>
                        <div class="f-14" style="padding: 10px 0;border-top:solid 1px #eee">
                            <span class="c-999">今日销售额</span>
                            <span>&yen; 1,234</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-24-xs-24 col-24-sm-12 col-24-md-12 col-24-lg-12 col-24-xl-6" style="padding-left: 12px; padding-right: 12px; margin-bottom: 24px;">
                <div class="panel">
                    <div class="panel-header" style="padding:15px 24px;font-weight: 400;color:#999;">总访问量：</div>
                    <div class="panel-body" style="padding:0 24px;">
                        <div class="c-success" style="font-size: 30px;line-height: 38px;padding-bottom: 24px;">
                            9,999,999
                        </div>
                        <div class="f-14" style="padding: 10px 0;border-top:solid 1px #eee">
                            <span class="c-999">今日访问量</span>
                            <span>1,234</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-24-xs-24 col-24-sm-12 col-24-md-12 col-24-lg-12 col-24-xl-6" style="padding-left: 12px; padding-right: 12px; margin-bottom: 24px;">
                <div class="panel">
                    <div class="panel-header" style="padding:15px 24px;font-weight: 400;color:#999;">总会员数：</div>
                    <div class="panel-body" style="padding:0 24px;">
                        <div class="c-danger" style="font-size: 30px;line-height: 38px;padding-bottom: 24px;">
                            99,999 人
                        </div>
                        <div class="f-14" style="padding: 10px 0;border-top:solid 1px #eee">
                            <span class="c-999">今日新增会员</span>
                            <span>1,234 人</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-24-xs-24 col-24-sm-12 col-24-md-12 col-24-lg-12 col-24-xl-6" style="padding-left: 12px; padding-right: 12px; margin-bottom: 24px;">
                <div class="panel">
                    <div class="panel-header" style="padding:15px 24px;font-weight: 400;color:#999;">总文章数：</div>
                    <div class="panel-body" style="padding:0 24px;">
                        <div class="c-warning" style="font-size: 30px;line-height: 38px;padding-bottom: 24px;">
                            99,999
                        </div>
                        <div class="f-14" style="padding: 10px 0;border-top:solid 1px #eee">
                            <span class="c-999">今日新增文章</span>
                            <span>1,234</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body"发布>
                <p>本次登录IP：{{ $_SERVER['REMOTE_ADDR'] }}</p>
                <p>本次登录时间：{{ date('Y-m-d H:i:s', time()) }}</p>
                <table class="table table-border table-bordered table-bg mt-20">
                    <thead>
                    <tr>
                        <th colspan="2" scope="col">服务器信息</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th width="30%">服务器域名</th>
                        <td><span id="lbServerName">{{ $_SERVER["HTTP_HOST"] }}</span></td>
                    </tr>
                    <tr>
                        <td>服务器IP地址</td>
                        <td>{{ GetHostByName($_SERVER['SERVER_NAME']) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </article>
    {{--页尾信息--}}
    <footer class="footer Hui-admin-footer">
        <p></p>
    </footer>
</div>
