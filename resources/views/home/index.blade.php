@extends('home.public.subject')
<div class="topDiv">
    <img src="{{ asset('home/images/img/firstImg.png') }}" alt=""/>
</div>
@section('content')
    <!--搜索部分-->
    <div class="container searchPart">
        <div class="relative">
            <img src="{{ asset('home/images/img/logo.png') }}" alt="" class="logoImg"/>
        </div>
        <div class="searchForm">
            <form action="" method="post">
                <fieldset class="fieldset">
                    <div class="searchDiv">
                        <input type="text" placeholder=""/>
                        <button type="submit" class="searchBtn">搜索</button>
                    </div>
                </fieldset>
            </form>
            <div class="hotSearch">
                <ul class="hotSearchList clearfix">
                    <li>
                        <a href=""  class="active mgl-10">水饺</a>
                    </li>
                    <li>
                        <a href="">大衣</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--分类导航-->
    <div class="typeNav">
        <div class="container">
            <ul class="navList clearfix">
                <li class="goodsType">
                    <a href="">商品分类</a>
                    <a class="typeIcon"></a>
                </li>
                <li class="navLi">
                    <a href="">首页</a>
                </li>
                <li class="navLi">
                    <a href="">黑名单公示</a>
                </li>
                <li class="navLi">
                    <a href="">投诉结果公示</a>
                </li>
                <li class="navLi">
                    <a href="">预售产品</a>
                </li>
                <li class="navLi">
                    <a href="">兼职工</a>
                </li>
                <li class="navLi">
                    <a href="">直营店和加盟</a>
                </li>
                <li class="navLi">
                    <a href="">白露倩影系列</a>
                </li>
                <li class="navLi">
                    <a href="">美容类</a>
                </li>
            </ul>
        </div>
    </div>
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
                            <a href="" class="canyinLevel1">{{ $category['name'] }} <span class="mgl-50">></span></a>
                            <ul class="canyinLevel2">
                                @foreach($category['children'] as $k => $children)
                                    <li>
                                        <p>{{ $children['name'] }}</p>
                                        @foreach($children['children'] as $s => $val)
                                            <a href="">{{ $val['name'] }}</a>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="payWay">
                <p class="payWayTittle">付款方式解读 :</p>
                <p class="payWayContent">顾客付款=商家（成本价）+顾客满印度顾客满意度=快递+商家服务+顾客的心情。将体验值直接换成钱。将钱花在有尊严和价值的服务上。</p>
            </div>
        </div>
        <!--热卖产品展示区-->
        <div class="hotGoodsShow relative">
            <p class="hotGoodsTittle">热卖产品展示区</p>
            <div class="wrap wrapperDiv">
                <div class="fenye">
                    <ul>
                        <li class="xifenye" id="xifenye">
                            <a id="xiye">1</a>/<a id="mo">3</a>
                        </li>
                        <li id="top" onclick="topclick()" class="leftArrow"><a href=""><</a></li>
                        <li id="down" onclick="downclick()" class="rightArrow"><a href="">></a></li>
                    </ul>

                </div>
            </div>
            <ul class="hotGoodsList clearfix">
                <li>
                    <a href="" class="hotGoodsLink">
                        <div class="imgDiv">
                            <img src="../images/img/hotGood.png" alt=""/>
                        </div>
                        <p class="hotName">451升WIFI智能家用风冷无451升WIFI智能家用风冷无</p>
                        <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                    </a>
                </li>
                <li>
                    <a href="" class="hotGoodsLink">
                        <div class="imgDiv">
                            <img src="../images/img/hotGood.png" alt=""/>
                        </div>
                        <p class="hotName">451升WIFI智能家用风冷无451升WIFI智能家用风冷无</p>
                        <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                    </a>
                </li>
                <li>
                    <a href="" class="hotGoodsLink">
                        <div class="imgDiv">
                            <img src="../images/img/hotGood.png" alt=""/>
                        </div>
                        <p class="hotName">451升WIFI智能家用风冷无451升WIFI智能家用风冷无</p>
                        <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                    </a>
                </li>
                <li>
                    <a href="" class="hotGoodsLink">
                        <div class="imgDiv">
                            <img src="../images/img/hotGood.png" alt=""/>
                        </div>
                        <p class="hotName">451升WIFI智能家用风冷无451升WIFI智能家用风冷无</p>
                        <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                    </a>
                </li>
                <li>
                    <a href="" class="hotGoodsLink">
                        <div class="imgDiv">
                            <img src="../images/img/hotGood.png" alt=""/>
                        </div>
                        <p class="hotName">451升WIFI智能家用风冷无451升WIFI智能家用风冷无</p>
                        <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                    </a>
                </li>
                <li>
                    <a href="" class="hotGoodsLink">
                        <div class="imgDiv">
                            <img src="../images/img/hotGood.png" alt=""/>
                        </div>
                        <p class="hotName">451升WIFI智能家用风冷无451升WIFI智能家用风冷无</p>
                        <p class="hotPrice"><span class="priceIcon">￥</span>2999.00</p>
                    </a>
                </li>
            </ul>
        </div>
        <!--优秀商家展示区-->
        <div class="perfectShop relative" id="perfectShop">
            <ul id="myTab" class="nav nav-tabs tabList">
                <li class="active mgl-650">
                    <a href="#canyin1" data-toggle="tab">
                        餐饮类1
                    </a>
                </li>
                <li>
                    <a href="#canyin2" data-toggle="tab">餐饮类2</a>
                </li>
                <li>
                    <a href="#canyin3" data-toggle="tab">
                        餐饮类3
                    </a>
                </li>
                <li>
                    <a href="#canyin4" data-toggle="tab">餐饮类4</a>
                </li>
                <li>
                    <a href="#all" data-toggle="tab">全部</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active canyin1" id="canyin1">
                    <ul class="clearfix">
                        <li class="perfectBl">
                            <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin2">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin3">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin4">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="all">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
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
                <li class="active mgl-650">
                    <a href="#canyin21" data-toggle="tab">
                        餐饮类1
                    </a>
                </li>
                <li>
                    <a href="#canyin22" data-toggle="tab">餐饮类2</a>
                </li>
                <li>
                    <a href="#canyin23" data-toggle="tab">
                        餐饮类3
                    </a>
                </li>
                <li>
                    <a href="#canyin24" data-toggle="tab">餐饮类4</a>
                </li>
                <li>
                    <a href="#all2" data-toggle="tab">全部</a>
                </li>
            </ul>
            <div id="myTabContent2" class="tab-content clearfix">
                <!--<div class="fl">-->
                <!--<img src="../images/img/artLeftImg.png" alt="" class="artLeftImg"/>-->
                <!--</div>-->
                <div class="tab-pane fade in active canyin1 canyin21 fl" id="canyin21">
                    <ul class="clearfix">
                        <li class="">
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
                        <li class="">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin22">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin23">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin24">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="all2">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
            </div>
            <div>
                <p class="perfectShopTip">经历和体验产品展示区</p>
            </div>
            <div class="artLeftImg">
                <img src="{{ asset('home/images/img/artLeftImg.png') }}" alt=""/>
            </div>
        </div>
        <!--娱乐产品展示区-->
        <div class="enjoyPart perfectShop relative" id="enjoyPart">
            <ul id="myTab3" class="nav nav-tabs tabList">
                <li class="active mgl-650">
                    <a href="#canyin1" data-toggle="tab">
                        餐饮类1
                    </a>
                </li>
                <li>
                    <a href="#canyin2" data-toggle="tab">餐饮类2</a>
                </li>
                <li>
                    <a href="#canyin3" data-toggle="tab">
                        餐饮类3
                    </a>
                </li>
                <li>
                    <a href="#canyin4" data-toggle="tab">餐饮类4</a>
                </li>
                <li>
                    <a href="#all" data-toggle="tab">全部</a>
                </li>
            </ul>
            <div id="myTabContent3" class="tab-content">
                <div class="tab-pane fade in active canyin1" id="canyin31">
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
                <div class="tab-pane fade in canyin1" id="canyin32">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-2.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin33">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-3.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="canyin34">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-4.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade in canyin1" id="all3">
                    <ul class="clearfix">
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                        <li>
                            <img src="../images/img/perfectGoods-5.png" alt="" class="perfectImg"/>
                            <p class="perfectName">以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可以纯线上品牌A21 2019冬季新 品保暖夹棉连帽中长风衣女 可</p>
                            <a href="" class="perfectShopBtn">进入商家店铺</a>
                        </li>
                    </ul>
                </div>
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
                <li class="active">
                    <a href="#canyin41" data-toggle="tab">
                        餐饮类1
                    </a>
                </li>
                <li>
                    <a href="#canyin42" data-toggle="tab">餐饮类2</a>
                </li>
                <li>
                    <a href="#canyin43" data-toggle="tab">
                        餐饮类3
                    </a>
                </li>
                <li>
                    <a href="#canyin44" data-toggle="tab">餐饮类4</a>
                </li>
                <li>
                    <a href="#all4" data-toggle="tab">全部</a>
                </li>
            </ul>
            <div id="myTabContent4" class="tab-content clearfix">
                <!--<div class="fl">-->
                <!--<img src="../images/img/artLeftImg.png" alt="" class="artLeftImg"/>-->
                <!--</div>-->
                <div class="tab-pane fade in active canyin1 canyin21 fl" id="canyin41">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin42">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin43">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin44">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="all4">
                    <ul class="clearfix">
                        <li class="mgl-203">
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
                        <li class="mgl-203">
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
            </div>
            <div class="qihuoTipDiv">
                <p class="qihuoTip">预售商品展示区</p>
            </div>
            <div class="qihuoLeftImg">
                <img src="{{ asset('home/images/img/qihuoLeftImg.png') }}" alt=""/>
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
                <li class="active">
                    <a href="#canyin61" data-toggle="tab">
                        餐饮类1
                    </a>
                </li>
                <li>
                    <a href="#canyin62" data-toggle="tab">餐饮类2</a>
                </li>
                <li>
                    <a href="#canyin63" data-toggle="tab">
                        餐饮类3
                    </a>
                </li>
                <li>
                    <a href="#canyin64" data-toggle="tab">餐饮类4</a>
                </li>
                <li>
                    <a href="#all6" data-toggle="tab">全部</a>
                </li>
            </ul>
            <div id="myTabContent6" class="tab-content clearfix">
                <!--<div class="fl">-->
                <!--<img src="../images/img/artLeftImg.png" alt="" class="artLeftImg"/>-->
                <!--</div>-->
                <div class="tab-pane fade in active canyin1 canyin21 fl" id="canyin61">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin62">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin63">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="canyin64">
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
                <div class="tab-pane fade in canyin1 canyin21 fl" id="all6">
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
