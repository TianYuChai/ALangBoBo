<li class="firstLevel">
    <p>{{ Auth::guard('web')->user()->category !=0 ? "商户":"个人" }}中心</p>
    <ul>
        @include('home.personal.head_portrait')
        <li>
            <a href="{{ route('personal.merchant_data') }}">用户资料</a>
        </li>
        <li>
            <a href="{{ route('personal.index') }}">帐户中心</a>
        </li>
        <li>
            <a href="{{ route('personal.address') }}">地址管理</a>
        </li>
        <li>
            <a href="{{ route('shopp.shopp.car') }}">我的购物车</a>
        </li>
        <li>
            <a href="{{ route('personal.havegoods', ['type' => 'allOrder']) }}">已买到的宝贝</a>
        </li>
        <li>
            <a href="{{ route('personal.sendtime.index') }}">兼职投递记录</a>
        </li>
        <li>
            <a href="{{ route('personal.demand.index') }}">百录倩影</a>
        </li>
        <li>
            <a href="{{ route('personal.creditmargin') }}">信用保证金</a>
        </li>
        @include('home.personal.judge_merchange')
        <li>
            <a href="{{ route('personal.cancellationuser') }}">注销帐户</a>
        </li>
    </ul>
</li>
