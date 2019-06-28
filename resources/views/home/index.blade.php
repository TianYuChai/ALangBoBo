@extends('home.public.subject')
{{--<div class="topDiv">--}}
    {{--<img src="{{ asset('home/images/img/firstImg.png') }}" alt=""/>--}}
{{--</div>--}}
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <!--产品内容部分-->
    <div class="container">
        <!--banner轮播部分-->
        <div id="myCarousel" class="carousel slide relative" data-ride="carousel" data-interval="2000">
            <!-- 轮播（Carousel）指标 -->
            <ol class="carousel-indicators">
                @foreach($data['banners'] as $key => $banner)
                    <li data-target="#myCarousel" data-slide-to="{{ $key }}" {{ $key == 0 ? 'class="active"' : '' }}></li>
                @endforeach
            </ol>
            <!-- 轮播（Carousel）项目 -->
            <div class="carousel-inner bannerList">
               @foreach($data['banners'] as $key => $banner)
                    <div class="item {{ $key == 0 ? "active" : "" }}">
                        <a href="{{ $banner['url'] }}" target=_black>
                            <img src="{{ FileUpload::url('image', $banner->image_url) }}" alt="暂无图片">
                        </a>
                    </div>
               @endforeach
            </div>
            <div class="navMenu">
                <ul class="navMenuList">
                    @foreach($data['categorys'] as $key => $category)
                        <li>
                            <a href="{{ url('product', ['type' =>'opther-' . $category['id']]) }}" class="canyinLevel1">{{ $category['name'] }} <span class="mgl-50">></span></a>
                            <ul class="canyinLevel2">
                                @foreach($category['children'] as $k => $children)
                                    <li>
                                        <p>{{ $children['name'] }}</p>
                                        @foreach($children['children'] as $s => $val)
                                            <a href="{{ url('product', ['type' =>'opther-' . $val['id']]) }}">{{ $val['name'] }}</a>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="payWay" style="z-index: 1">
                {{--<p class="payWayTittle">付款方式解读 :</p>--}}
                {{--<p class="payWayContent">顾客付款=商家（成本价）+顾客满印度顾客满意度=快递+商家服务+顾客的心情。将体验值直接换成钱。将钱花在有尊严和价值的服务上。</p>--}}
                <img src="{{ asset('home/images/img/righttext.gif') }}" alt=""/>
            </div>
        </div>
        <!--热卖产品展示区-->
        <div class="hotGoodsShow relative">
            <p class="hotGoodsTittle">热卖产品展示区</p>
            {{--<div class="wrap wrapperDiv">--}}
                {{--<div class="fenye">--}}
                    {{--<ul>--}}
                        {{--<li class="xifenye" id="xifenye">--}}
                            {{--<a id="xiye">1</a>/<a id="mo">{{ ceil(count($data['selling_goods']) / 6) }}</a>--}}
                        {{--</li>--}}
                        {{--<li id="top" onclick="topclick()" class="leftArrow"><a href="javascript:void(0)"><</a></li>--}}
                        {{--<li id="down" onclick="downclick()" class="rightArrow"><a href="javascript:void(0)">></a></li>--}}
                    {{--</ul>--}}

                {{--</div>--}}
            {{--</div>--}}
            <ul class="hotGoodsList clearfix">
                @foreach($data['selling_goods'] as $good)
                    <li>
                        <a href="{{ url('details', ['id' => $good->id]) }}" class="hotGoodsLink" target="_blank">
                            <div class="imgDiv">
                                <img src="{{ FileUpload::url('image', $good['cost_img']) }}" alt=""/>
                            </div>
                            <p class="hotName">{{ $good->title }}</p>
                            <p class="hotPrice"><span class="priceIcon">￥</span>{{ $good->total_price }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--优秀商家展示区-->
        <div class="perfectShop relative" id="perfectShop">
            <ul id="myTab" class="nav nav-tabs tabList">
                @foreach($data['good_business_category'] as $key => $category)
                <li class="{{ $key == 0 ? 'active mgl-650' : '' }}">
                    <a href="#{{ $category['id'] }}" data-toggle="tab">
                        {{ $category['value'] }}
                    </a>
                </li>
                @endforeach
            </ul>
            <div id="myTabContent" class="tab-content">
                @foreach($data['good_business'] as $key => $good_business)
                <div class="tab-pane fade in {{ $key == 6 ? 'active' : '' }} canyin1" id="{{ $key }}">
                    <ul class="clearfix">
                        @foreach($good_business as $good_busines)
                            <li class="perfectBl">
                                <img src="{{ FileUpload::url('image', $good_busines->cost_img) }}" alt="" class="perfectImg"/>
                                <p class="perfectName">
                                    {{ $good_busines->title }}
                                </p>
                                <a href="{{ route('merchant.show', ['id' => $good_busines->user->merchant['id']]) }}"
                                   class="perfectShopBtn" target="_blank">进入商家店铺</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            <div>
                <p class="perfectShopTip">优秀商家产品展示区</p>
            </div>
        </div>
        <!--经历和体验产品展示区-->
        <div class="perfectShop relative artPart clearfix" id="artPart">
            <!--<div class="perfectNav">-->
            <!--<p></p>-->
            <!--</div>-->
            <ul id="myTab2" class="nav nav-tabs tabList">
                @foreach(\App\Http\Models\home\demandModel::$_DISPLAY as $key => $display)
                    <li class="{{ $key == 101 ? 'active mgl-650' : '' }}">
                        <a href="#{{ $key }}" data-toggle="tab">
                            {{ $display }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div id="myTabContent2" class="tab-content clearfix">
                @foreach($data['demands'] as $key => $demand)
                <div class="tab-pane fade in {{ $key == 101 ? 'active' : '' }} canyin1 {{ $key }} fl" id="{{ $key }}">
                    <ul class="clearfix">
                        @foreach($demand as $item)
                            <li class="mgl-10">
                                <a href="{{ route('demand.show', ['id' => $item->id]) }}"
                                    class="block artPartLink" target="_blank">
                                    <img src="{{ FileUpload::url('image', $item->img) }}" alt="" class="perfectImg"/>
                                    <p class="perfectName">{{ $item->title }}</p>
                                    <p class="hotprice"><span class="priceicon">￥</span>{{ $item->moneys }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            <div>
                <p class="perfectShopTip">经历和体验产品展示区</p>
            </div>
            <div class="artLeftImg">
                <img src="{{ asset('home/images/img/artLeftImg.gif') }}" alt=""/>
            </div>
        </div>
        <!--娱乐产品展示区-->
        <div class="enjoyPart perfectShop relative" id="enjoyPart">
            <ul id="myTab3" class="nav nav-tabs tabList">
                @foreach($data['recreationProducts'] as $key => $recreationProducts)
                <li class="{{ $key == 0 ? 'active mgl-650' : ''  }}">
                    <a href="#{{ $recreationProducts['id'] }}" data-toggle="tab">
                        {{ $recreationProducts['value'] }}
                    </a>
                </li>
                @endforeach
            </ul>
            <div id="myTabContent3" class="tab-content">
                @foreach($data['recreationProductss'] as $key => $recreationProductss)
                    <div class="tab-pane fade in {{ $key == 25 ? 'active' : '' }} canyin1" id="{{ $key }}">
                        <ul class="clearfix">
                            @foreach($recreationProductss as $productss)
                            <li>
                                <a href="{{ url('details', ['id' => $productss->id]) }}" target="_blank">
                                    <img src="{{ FileUpload::url('image', $productss->cost_img) }}" alt="" class="perfectImg"/>
                                    <p class="enjoyName">
                                        {{ $productss->title }}
                                    </p>
                                    <p class="enjoyPrice"><span class="font-normal">￥</span>{{ $productss->total_price }}</p>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="enjoyPartTipDiv">
                <p class="enjoyPartTip">娱乐产品展示区</p>
            </div>
        </div>
        <!--预售商品展示区-->
        <div class="perfectShop relative artPart clearfix qihuoPart" id="qihuoPart">
            <!--<div class="perfectNav">-->
            <!--<p></p>-->
            <!--</div>-->
            <ul id="myTab4" class="nav nav-tabs tabList">
                @foreach($data['presellGoods'] as $key => $presellGoods)
                    <li class="{{ $key == 0 ? 'active' : '' }}">
                        <a href="#{{ $presellGoods['id'] }}" data-toggle="tab">
                            {{ $presellGoods['value'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div id="myTabContent4" class="tab-content clearfix">
                @foreach($data['presellGoodss'] as $key => $presellGoodss)
                <div class="tab-pane fade in {{ $key == 19 ? 'active' : '' }} canyin1 canyin21 fl" id="{{ $key }}">
                    <ul class="clearfix">
                        @foreach($presellGoodss as $goodss)
                            <li>
                                <a href="{{ url('details', ['id' => $goodss->id]) }}" class="block artPartLink" target="_blank">
                                    <img src="{{ FileUpload::url('image', $goodss->cost_img) }}" alt="" class="perfectImg"/>
                                    <p class="perfectName">
                                        {{ $goodss->title }}
                                    </p>
                                    <p class="hotPrice"><span class="priceIcon">￥</span>{{ $goodss->total_price }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            <div class="qihuoTipDiv">
                <p class="qihuoTip">预售商品展示区</p>
            </div>
            <div class="qihuoLeftImg">
                <img src="{{ asset('home/images/img/qihuoLeftImg.gif') }}" alt=""/>
            </div>
        </div>
        <!--艺术品拍卖区-->
        <div class="enjoyPart perfectShop relative" id="yishuPart">
            <ul id="myTab5" class="nav nav-tabs tabList">
                <li class="active mgl-650">
                    <a href="#canyin51" data-toggle="tab">
                        餐饮类1
                    </a>
                </li>
                <li>
                    <a href="#canyin52" data-toggle="tab">餐饮类2</a>
                </li>
                <li>
                    <a href="#canyin53" data-toggle="tab">
                        餐饮类3
                    </a>
                </li>
                <li>
                    <a href="#canyin54" data-toggle="tab">餐饮类4</a>
                </li>
                <li>
                    <a href="#all5" data-toggle="tab">全部</a>
                </li>
            </ul>
            <div id="myTabContent5" class="tab-content">
                <div class="tab-pane fade in active canyin1" id="canyin51">
                    <ul class="clearfix">
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin52">
                    <ul class="clearfix">
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin53">
                    <ul class="clearfix">
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin54">
                    <ul class="clearfix">
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="all5">
                    <ul class="clearfix">
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="enjoyName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="enjoyPrice"><span class="font-normal">￥</span>3799.00</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="yishuPartTipDiv">
                <p class="enjoyPartTip">艺术品拍卖区</p>
            </div>
        </div>
        <!--代办服务展示区-->
        <div class="perfectShop relative artPart clearfix qihuoPart" id="daibanPart">
            <!--<div class="perfectNav">-->
            <!--<p></p>-->
            <!--</div>-->
            <ul id="myTab6" class="nav nav-tabs tabList">
                @foreach($data['commissionCategory'] as $key => $commissioncategory)
                    <li class="{{ $key == 0 ? 'active' : '' }}">
                        <a href="#{{ $commissioncategory->id }}" data-toggle="tab">
                            {{ $commissioncategory->cate_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div id="myTabContent6" class="tab-content clearfix">
                @foreach($data['commissions'] as $key => $commissions)
                <div class="tab-pane fade in {{ $key == '' ? 'active' : '' }} canyin1 canyin21 fl" id="{{ $key }}">
                    <ul class="clearfix">
                        <li>
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li class="mgl-10">
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li class="mgl-10">
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li class="mgl-10">
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li class="mgl-10">
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li class="mgl-10">
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                        <li class="mgl-10">
                            <a href="" class="block artPartLink">
                                <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                                <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                                <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                            </a>
                        </li>
                    </ul>
                </div>
                @endforeach
            </div>
            <div class="daibanTipDiv">
                <p class="qihuoTip">代办服务展示区</p>
            </div>
            <div class="qihuoLeftImg">
                <img src="{{ asset('home/images/img/daibanLeftImg.png') }}" alt=""/>
            </div>
        </div>
    </div>
@endsection
@section('section')
<script type="text/javascript">
    // 返回顶部
    $(function(){
        $('.backTop').click(function(){
            $('html , body').animate({scrollTop: 0},'slow');
        });
    });
    if($.support.leadingWhitespace == false){
        $("#myTabContent2 li:nth-child(1)").css("margin-left","203px");
        $("#myTabContent2 li:nth-child(5)").css("margin-left","203px");
    }
</script>
@endsection
