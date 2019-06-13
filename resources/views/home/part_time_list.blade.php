@extends('home.public.subject')
@section('title', '兼职列表')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/productDetail-partJob.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/experience-index.css') }}"/>
    <link href="{{ asset('home/common/pagination.css') }}" rel="stylesheet">
    <script src="{{ asset('home/js/jquery.pagination.js') }}"></script>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container">
        <p class="productType">兼职工></p>
        <div class="productDetail">
            <ul class="clearfix type brand">
                <li>工作类型：</li>
                @foreach($categorys as $category)
                    <li class="{{ Input::get('category', '') == $category->id ? 'typeActive' : ''}}">
                        <a href="?category={{ $category->id }}">{{ $category->cate_name }}</a>
                    </li>
                @endforeach
            </ul>
            <ul class="clearfix type typeList">
                <li>结算工资方式：</li>
                @foreach($settles as $key => $settle)
                    <li class="{{ Input::get('settle', '') == $key ? 'typeActive' : ''}}">
                        <a href="javascript:void(0)" data-key="{{ $key }}" class="settle">按{{ $settle }}</a>
                    </li>
                @endforeach
            </ul>
            <ul class="clearfix type">
                <li>工资区间：</li>
                <li class="wages">
                    <input type="text"
                           placeholder="￥"
                           class="mgl-20"
                           name="min_price"
                           value="{{ Input::get('min_price', '') }}"
                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                           onblur="this.v();"/>
                    -
                    <input type="text"
                           placeholder="￥"
                           name="max_price"
                           value="{{ Input::get('max_price', '') }}"
                           onkeyup="this.value= this.value.match(/\d+(\.\d{0,2})?/) ? this.value.match(/\d+(\.\d{0,2})?/)[0] : ''"
                           onblur="this.v();"/>
                    <a href="javascript:void(0)" class="wagesBtn">确定</a>
                </li>
            </ul>
        </div>
        <!--兼职岗位-->
        <div class="clearfix">
            <p class="partJobTip">兼职岗位</p>
        </div>
        <div class="clearfix">
            <table class="fl needTable">
                <thead>
                <tr>
                    <th>薪酬</th>
                    <th>招聘职位</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <tbody>
                    @if(!$items->isEmpty())
                        @foreach($items->chunk(3)[0] as $item)
                            <tr>
                                <td class="col-red">￥{{ $item->moneys }}元</td>
                                <td>
                                    <a href="{{ route('partime.show', ['id' => $item->id]) }}" target="_blank">
                                        {{ $item->title }}
                                    </a>
                                </td>
                                <td class="font-12 col-gray">{{ $item->created_at }} 发布</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <table class="fl needTable">
                <thead>
                <tr>
                    <th>价格</th>
                    <th>招聘职位</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <tbody>
                    @if(!$items->isEmpty() && count($items->chunk(3)) >= 2)
                        @foreach($items->chunk(3)[1] as $item)
                            <tr>
                                <td class="col-red">￥{{ $item->moneys }}元</td>
                                <td>
                                    <a href="{{ route('partime.show', ['id' => $item->id]) }}" target="_blank">
                                        {{ $item->title }}
                                    </a>
                                </td>
                                <td class="font-12 col-gray">{{ $item->created_at }} 发布</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="tc paginationDiv mgt-30">
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
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
        $('.settle').click(function () {
            let key = $(this).data('key');
            let url = location.href;
            let url_array = url.split('?');
            if(url_array.length > 1) {
                window.location.href = url + '&settle='+key;
            } else {
                window.location.href = url + '?settle='+key;
            }
        });
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
