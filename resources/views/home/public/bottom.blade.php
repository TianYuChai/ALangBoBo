<!--底部-->
<div class="bottomPart">
    <div class="container">
        <div class="copyRight">
            <ul class="clearfix">
                <li>
                    <p href="javascript:void(0)">购物指南</p>
                    <a href="{{ route('index.button', ['id' => 1]) }}">导购演示</a>
                    <a href="{{ route('index.register') }}">免费注册</a>
                    <a href="{{ route('index.button', ['id' => 2]) }}">常见问题</a>
                </li>
                <li>
                    <p href="javascript:void(0)">支付方式</p>
                    <a href="javascript:void(0)">网银支付</a>
                    <a href="javascript:void(0)">快捷支付</a>
                    <a href="javascript:void(0)">认缴支付</a>
                </li>
                <li>
                    <p href="javascript:void(0)">商家服务</p>
                    <a href="{{ route('index.button', ['id' => 3]) }}">商家入驻</a>
                    <a href="{{ route('index.button', ['id' => 4]) }}">培训中心</a>
                    <a href="{{ route('index.button', ['id' => 5]) }}">商家帮助</a>
                    <a href="{{ route('index.button', ['id' => 6]) }}">服务市场</a>
                    <a href="{{ route('index.button', ['id' => 7]) }}">规则中心</a>
                </li>
            </ul>
        </div>
        <p class="copyRightTip">Copyright© 2002-2019，阿郎博波文化传媒（深圳）有限公司版权所有  |  浙公网安备 32010202010078号| 浙ICP备10207551号-4</p>
        <img src="{{ asset('home/images/img/bottomImg.png') }}" alt="" class="bottomImg"/>
    </div>
</div>
