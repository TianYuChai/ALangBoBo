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
            <a href="../html/shopCarList-sum.html">我的购物车</a>
        </li>
        <li>
            <a href="../html/merchantCenter_buyThings.html">已买到的宝贝</a>
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
