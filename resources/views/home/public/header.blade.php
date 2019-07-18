<!--头部导航-->
<div class="topNav">
    <div class="container clearfix">
        <div class="fl">
            <ul class="leftNavList clearfix">
                <li class="fl relative">
                    <!--当前城市-->
                    <!--如果 浏览器为 ie 之外的浏览器时 显示此 div 内容-->
                    <!--除IE外都可识别-->
                    <!--[if !IE]><!-->
                    <div class="search">
                        <div class="citySelect">
                            <i class="locationIcon"></i>
                            <span class="cityName inline-block">深圳</span>
                            <i class="iconDown db-n"></i>
                            <i class="line"></i>
                        </div>
                        <div class="dropDown">
                            <div class="dropProv">
                                <ul class="dropProvUl dropUl"></ul>
                            </div>
                            <div class="dropCity">
                                <ul class="dropCityUl dropUl"></ul>
                            </div>
                        </div>
                    </div>
                    <!--<![endif]-->
                    <!--所有的IE可识别-->
                    <!--[if IE]>
                    <div data-toggle="distpicker" style="line-height: 42px;">
                        <img src='{{ asset("home/images/icon/location.png") }}' alt="" style="display: inline-block;margin-top:-3px;"/>
                        <select data-province="-省-" class="outline" style="width:50px;height:24px;"></select>
                        <select data-city="-市-" class="outline" style="width:70px;height:24px;"></select>
                    </div>
                    <![endif]-->
                </li>
                @if(!auth()->guard('web')->check())
                    <li class="fl mgl-80 relative">
                        <a class="mgr-20" href="{{ route('index.login') }}" target="_blank">登录</a>
                    </li>
                    <li class="fl relative">
                        <a class="lightGray" href="{{ route('index.register') }}" target="_blank">注册</a>
                    </li>
                @else
                    <li class="fl mgl-80 relative">
                        <a class="mgr-20" href="{{ route('personal.index') }}" target="_blank">{{ Auth::guard('web')->user()->account }}</a>
                    </li>
                    <li class="fl relative">
                        <a class="lightGray" href="{{ route('index.login.loginout') }}" >退出</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="fr">
            <ul class="clearfix rightNavList">
                <li class="rightNavLi">
                    <a href="{{ route('personal.havegoods', ['type' => 'allOrder']) }}">订单消息</a>
                </li>
                <li class="rightNavLi">
                    <a href="{{ url('/') }}">网页导航</a>
                </li>
                {{--<li class="rightNavLi">--}}
                    {{--<a href="">商家服务</a>--}}
                {{--</li>--}}
                <li class="rightNavLi br-n">

                    <a href="http://wpa.qq.com/msgrd?v=3&uin={{ \App\Http\Models\setup\kefuModel::first()['content'] }}&site=qq&menu=yes" target="_blank">客服</a>
                </li>
                <li class="fl shopCar">
                    <a href="{{ route('shopp.shopp.car') }}" class="relative">
                        <img src="{{ asset('home/images/icon/car.png') }}" alt=""/>
                        <span>我的购物车</span>
                        <i>{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->shopp_car_num : 0 }}</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

