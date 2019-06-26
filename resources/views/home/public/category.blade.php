<div class="typeNav">
    <div class="container">
        <ul class="navList clearfix">
            <li class="goodsType">
                <a href="">商品分类</a>
                <a class="typeIcon"></a>
            </li>
            <li class="navLi">
                <a href="{{ url('/') }}">首页</a>
            </li>
            <li class="navLi">
                <a href="{{ url('theBlacklist') }}">黑名单公示</a>
            </li>
            <li class="navLi">
                <a href="{{ url('product', ['type' => 'presell-all']) }}">预售产品</a>
            </li>
            <li class="navLi">
                <a href="{{ url('partime') }}">兼职工</a>
            </li>
            <li class="navLi">
                <a href="{{ url('merchant') }}">直营店和加盟</a>
            </li>
            <li class="navLi">
                <a href="{{ url('demand') }}" target="_blank">百录倩影系列</a>
            </li>
            {{--<li class="navLi">--}}
                {{--<a href="{{ url('product', ['type' =>'opther-16']) }}">美容类</a>--}}
            {{--</li>--}}
        </ul>
    </div>
</div>
