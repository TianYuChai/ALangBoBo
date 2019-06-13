@extends('home.public.subject')
@section('title', "店铺商品展示")
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
        {{--<p class="productType">--}}
            {{--{{ $category_goodss['nav'] }}>--}}
        {{--</p>--}}
        <div class="productDetail">
            <ul class="clearfix type">
                <li>种类：</li>
                @foreach($categorys as $category)
                    <li>
                        <a href="{{ route('merchant.evenmore', ['id' => $id]) }}?category={{ $category->id }}"
                           class="{{ $category->id == Input::get('category', '') ? 'typeActive' : '' }}">
                            {{ $category->name }}</a>
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
                        <a href="javascript:void(0)" class="wagesBtn">确定</a>
                    </li>
                </form>
            </ul>
        </div>
        <!--商品内容部分-->
        <div class="productDiv">
            <ul class="productList clearfix">
                @foreach($goods as $good)
                    <li>
                        <a class="productA" href="{{ url('details', ['id' => $good->id]) }}">
                            <img src="{{ FileUpload::url('image', $good->cost_img) }}" alt="" class="productImg"/>
                            <p class="productText">{!! $good->title !!}</p>
                            <p class="productPrice">￥{!! $good->total_price !!}</p>
                        </a>
                        <a href="{{ route('merchant.show', ['id' => $good->user->merchant['id']]) }}" class="shopLink">
                            {{--<img src="" alt="" class="shopIcon"/>--}}
                            {{ $good->user->merchant['shop_name'] }}
                            <span class="mgl-70">{{ $good->user->merchant['address'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tc paginationDiv">
                {!! $goods->links() !!}
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

            $('.wagesBtn').click(function () {
                let url = location.href;
                let min_price = $('input[name="min_price"]').val();
                let max_price = $('input[name="max_price"]').val();
                let url_array = url.split('?');
                if(url_array.length > 1) {
                    window.location.href = url + '&min_price='+min_price + '&max_price='+max_price;
                } else {
                    window.location.href = url + '?min_price='+min_price + '&max_price='+max_price;
                }
            });
        });
    </script>
@endsection

