@extends('home.public.subject')
@section('title', "商品展示")
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container">
        <p class="productType">
            {{ $category_goodss['nav'] }}>
        </p>
        <div class="productDetail">
            <ul class="clearfix type">
                <li>种类：</li>
                @foreach($category_goodss['categorys'] as $categorys)
                    <li>
                        <?php $type = $category_goodss['nav'] == '预售产品' ? 'presell' : 'opther'?>
                        <a href="{{ url('product', ['type' => $type . '-' . $categorys->id]) }}"
                           class="{{ Input::get('category') == $categorys->id ? 'typeActive' : '' }}">
                            {{ $categorys->cate_name }}</a>
                    </li>
                @endforeach
            </ul>
            <!--价格页面样式调整-->
            <ul class="clearfix type">
                <li>价格：</li>
                <form action="" method="get" id="price">
                    <li class="wages">
                        <input type="text" placeholder="￥" class="mgl-20"
                               name="min_price"
                               value="{{ Input::get('min_price', '') }}"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();"/>
                        -
                        <input type="text" placeholder="￥" name="max_price"
                               value="{{ Input::get('max_price', '') }}"
                               onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                               onblur="this.v();"/>
                        <a onclick="document:price.submit()" class="wagesBtn">确定</a>
                    </li>
                </form>
            </ul>
            {{--<ul class="band clearfix">--}}
                {{--<li>品牌：</li>--}}
                {{--<li><a href="" class="bandActive">国内</a></li>--}}
                {{--<li><a href="">国外</a></li>--}}
            {{--</ul>--}}
        </div>
        <!--商品内容部分-->
        <div class="productDiv">
            <ul class="productList clearfix">
                @foreach($category_goodss['goods'] as $goodss)
                    <li>
                        <a class="productA">
                            <img src="{{ FileUpload::url('image', $goodss->cost_img) }}" alt="" class="productImg"/>
                            <p class="productText">{!! $goodss->title !!}</p>
                            <p class="productPrice">￥{!! $goodss->total_price !!}</p>
                        </a>
                        <a href="" class="shopLink">
                            {{--<img src="" alt="" class="shopIcon"/>--}}
                            {{ $goodss->user->merchant['shop_name'] }}
                            <span class="mgl-70">{{ $goodss->user->merchant['address'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tc paginationDiv">
                {!! $category_goodss['goods']->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script src="{{ asset('home/js/toPage.js') }}"></script>
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

