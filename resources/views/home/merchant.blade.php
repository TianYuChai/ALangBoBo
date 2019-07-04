@extends('home.public.subject')
@section('title', '直营和加盟')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/productDetail-directJoin.css') }}"/>
    <link href="{{ asset('home/common/pagination.css') }}" rel="stylesheet">
    <script src="{{ asset('home/js/jquery.pagination.js') }}"></script>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container">
        <p class="productType">直营店和加盟店></p>
        <!--商品内容部分-->
        <div class="productDiv">
            <ul class="productList clearfix">
                @foreach($items as $item)
                    <li>
                        <a class="productA" href="{{ route('merchant.show', ['id' => $item->id]) }}">
                            <img src="{{ FileUpload::url('image', $item->trademark) }}" alt="" class="productImg"/>
                            <p class="productText">{{ $item->shop_name }}</p>
                            {{--<p class="productText">主营品牌：同仁堂</p>--}}
                        </a>
                        <a href="{{ route('merchant.show', ['id' => $item->id]) }}" class="shopLink">
                            <img src="{{ asset('home/images/icon/shopIcon.png') }}" alt="" class="shopIcon"/>
                            {{ $item->dist_name }}
                            <span class="mgl-70">{{ mb_substr($item->arrdess, 0, 3, 'utf-8') }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tc paginationDiv">
                {!! $items->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script src="{{ asset('home/js/toPage.js') }}"></script>
@endsection
@section('section')
<script>
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
    //    品牌和分类点击切换选中状态
    $(".type li").on('click',function(){
        $(this).siblings().removeClass('typeActive');
        $(this).addClass('typeActive');
    });
    $(".typeList li").on('click',function(){
        $(this).siblings().removeClass('typeActive');
        $(this).addClass('typeActive');
    })
</script>
@endsection
