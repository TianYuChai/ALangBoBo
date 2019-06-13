@extends('home.public.subject')
@section('title', '直营和加盟')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/shop-net.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shop-join.css') }}"/>
@endsection
@section('content')
    <!--搜索部分-->
    <div class="container searchPart">
        <div class="relative">
            <div class="netShopName">
                <div class="clearfix">
                    @if($item->distinguish != 0)
                        <img src="{{ asset('home/images/img/logo.png') }}" alt="" class="shopLogo"/>
                    @endif
                    @if($item->distinguish != 2)
                        <img src="{{ FileUpload::url('image', $item->trademark) }}"
                             alt=""
                             class="netShopNameImg" style="width: 293px;height: 62px"/>
                    @endif
                </div>
                @if($item->distinguish == 1)
                    <p>{{ $item->dist_name }}：<span>{{ $item->code }}</span></p>
                @endif
                <p>店铺：<span>{{ $item->shop_name }}</span></p>
            </div>
        </div>
        <div class="searchForm netShopSearch relative">
            <form action="{{ route('merchant.evenmore', ['id' => $item->id]) }}" method="get">
                <fieldset class="fieldset">
                    <div class="searchDiv relative">
                        <input type="text" placeholder="店铺搜索" name="keyword"/>
                        <button type="submit" class="searchBtn">搜索</button>
                        <i></i>
                    </div>
                    <p class="netShopAddress">地址：{{ $item->arrdess }}</p>
                </fieldset>
            </form>
            <img src="{{ FileUpload::url('image', $item->qr_code) }}" alt="{{ $item->user->number }}" class="shopCode"/>
        </div>
    </div>
    <!--导航部分-->
    <div class="navLine">
        <div class="container">
            <ul class="netShopNav clearfix">
                @foreach($item->categorys as $category)
                    <li>
                        <a href="{{ route('merchant.evenmore', ['id' => $item->id]) }}?category={{$category->id}}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--轮播-->
    <div class="container">
        <div id="myCarousel" class="carousel slide relative bannerDiv" data-ride="carousel" data-interval="2000">
            <!-- 轮播（Carousel）指标 -->
            <ol class="carousel-indicators">
                @foreach($item->img as $key => $img)
                    <li data-target="#myCarousel" data-slide-to="0" class="{{ $key == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <!-- 轮播（Carousel）项目 -->
            <div class="carousel-inner">
                @foreach($item->img as $k => $value)
                    <div class="item {{ $k == 0 ? 'active' : '' }}">
                        <a href="{{ $value->url }}" target="_blank">
                            <img src="{{ FileUpload::url('image', $value->image) }}" alt=""
                                 style="width: 1170px; height: 624px">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--新品部分-->
    <div class="container mgt-30">
        <img src="{{ asset('home/images/img/netShopFengexian.png') }}" alt="" class="netShopFengexian"/>
        <div class="netShopNew">
            <ul class="clearfix">
                @foreach($goods as $good)
                    @if($good->new_goods == 1)
                        <li>
                            <a href="{{ url('details', ['id' => $good->id]) }}">
                                <img src="{{ FileUpload::url('image', $good->cost_img) }}" alt="" style="width: 279px; height: 311px;"/>
                                <p>{{ $good->title }}</p>
                                <img src="{{ asset('home/images/img/netShopNewicon.png') }}"
                                     alt="" class="netShopNewicon">
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <!--所有产品-->
    <div class="allGoods container mgb-200">
        <div class="clearfix allGoodsTittle">
            <p class="fl"> 所有产品</p>
            <a href="{{ route('merchant.evenmore', ['id' => $item->id]) }}" class="fr">更多 > </a>
        </div>
        <ul class="allGoodsList clearfix">
            @foreach($goods as $good)
                <li>
                    <a href="{{ url('details', ['id' => $good->id]) }}">
                        <img src="{{ FileUpload::url('image', $good->cost_img) }}" alt="" style="width: 172px; height: 171px"/>
                        <p class="allGoodsText">{{ $good->title }}</p>
                        <p class="allGoodsPrice">￥<span>{{ $good->total_price }}</span></p>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
<script>
    $(function(){
        if($.support.leadingWhitespace == false){
            $(".netShopNew ul li:nth-child(4n)").css("margin-right","0!important");
            $(".allGoodsList li:nth-child(5n)").css("margin-right","0!important");
        }
    })
</script>
@endsection

