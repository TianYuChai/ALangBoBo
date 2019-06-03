<div class="rightNav">
    <div>
        <a href="{{ route('personal.index') }}" class="rightPerson">
            <img src="{{ asset('home/images/icon/rightPerson.png') }}" alt=""/>
        </a>
        <div>
            <a href="{{ route('shopp.shopp.car') }}" class="rightCar">
                <img src="{{ asset('home/images/icon/rightCar.png') }}" alt=""/>
                <p>购物车</p>
                <span>{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->shopp_car_num : 0 }}</span>
            </a>
        </div>
        <a href="javascript:void(0)" class="backTop">
            <img src="{{ asset('home/images/icon/rightTop.png') }}" alt=""/>
        </a>
    </div>
</div>
