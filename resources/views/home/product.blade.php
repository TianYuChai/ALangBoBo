@extends('home.public.subject')
@section('title', "商品展示")
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
@endsection
@section('content')
    <div class="container">
        <p class="productType">百货类/红酒></p>
        <div class="productDetail">
            <ul class="clearfix type">
                <li>种类：</li>
                <li><a href="" class="typeActive">红酒</a></li>
                <li><a href="">白酒</a></li>
                <li><a href="">啤酒</a></li>
                <li><a href="">床单</a></li>
                <li><a href="">被子</a></li>
                <li><a href="">男装</a></li>
            </ul>
            <!--<ul class="price clearfix">-->
            <!--<li>价格：</li>-->
            <!--<li>-->
            <!--<form class="cmxform" method="get" action="">-->
            <!--<fieldset class="fieldset clearfix">-->
            <!--<div class="priceDiv relative fl mgr-10">-->
            <!--<i class="priceIcon1"></i>-->
            <!--<input type="text"/>-->
            <!--<span>-</span>-->
            <!--<i class="priceIcon2"></i>-->
            <!--<input type="text"/>-->
            <!--</div>-->
            <!--<div class="sureBtn fl relative">-->
            <!--<button class="submit" type="submit">确定</button>-->
            <!--</div>-->
            <!--</fieldset>-->
            <!--</form>-->
            <!--</li>-->
            <!--</ul>-->
            <!--价格页面样式调整-->
            <ul class="clearfix type">
                <li>价格：</li>
                <li class="wages">
                    <input type="text" placeholder="￥" class="mgl-20"/>
                    -
                    <input type="text" placeholder="￥"/>
                    <a href="" class="wagesBtn">确定</a>
                </li>
            </ul>
            <ul class="band clearfix">
                <li>品牌：</li>
                <li><a href="" class="bandActive">国内</a></li>
                <li><a href="">国外</a></li>
            </ul>
        </div>
        <!--商品内容部分-->
        <div class="productDiv">
            <ul class="productList clearfix">
                <li>
                    <a class="productA">
                        <img src="../images/img/productImg.png" alt="" class="productImg"/>
                        <p class="productText">圣芝红酒法国波尔多AOC银奖</p>
                        <p class="productPrice">￥449.00</p>
                    </a>
                    <a href="" class="shopLink">
                        <img src="../images/icon/shopIcon.png" alt="" class="shopIcon"/>
                        A商家
                        <span class="mgl-70">江苏南京</span>
                    </a>
                </li>
            </ul>
            <div class="tc paginationDiv">
                {{--分页--}}
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script src="../js/toPage.js"></script>
@endsection
@section('section')
    <script type="text/javascript">
        // 返回顶部
        $(function(){
            $('.backTop').click(function(){
                $('html , body').animate({scrollTop: 0},'slow');
            });
            if($.support.leadingWhitespace == false){
                $(".productList li:nth-child(5n)").css("margin-right","0px!important");
                $(".priceIcon1").css({"position":"absolute","top":"15px","left":"8px"});
                $(".priceIcon2").css({"position":"absolute","top":"15px","left":"80px"});
                $(".productDetail .priceDiv input").css("margin-top","5px");
//            $(".productDetail .sureBtn button").css("margin-top","-5px");
                $(".productDetail  .sureBtn button").css({"vertical-align":"top","margin-top":"5px"});
            }
        });
    </script>
@endsection

