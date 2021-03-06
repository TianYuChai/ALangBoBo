@if(Auth::guard('web')->user()->whermerchant)
    <li class="firstLevel">
        <p>店铺管理</p>
        <ul>
            <li>
                <a href="{{ route('personal.shop.index') }}">店招更换</a>
            </li>
            <li>
                <a href="{{ route('personal.shop.menu') }}">导航菜单栏</a>
            </li>
            <li>
                <a href="{{ route('personal.shop.banner') }}">店铺轮播</a>
            </li>
            <li>
                <a href="{{ route('personal.shop.goods') }}">商品管理</a>
            </li>
            <li>
                <a href="{{ route('personal.partime.index') }}">兼职管理</a>
            </li>
            <li>
                <a href="{{ route('personal.shop.order', ['type' => 'allOrder']) }}">订单管理</a>
            </li>
        </ul>
    </li>
    <li class="firstLevel">
        <p>分享推广</p>
        <ul>
            <li>
                <a href="{{ route('personal.shop.generalize') }}">推广管理</a>
            </li>
        </ul>
    </li>
@endif
