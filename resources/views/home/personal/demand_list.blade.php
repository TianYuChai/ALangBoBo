@extends('home.public.subject')
@section('title', '阿朗博波-个人中心-百录倩影管理')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/common/base.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/common/normalize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_buyThings.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_productManage.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/distpicker/2.0.3/distpicker.js"></script>
    <style type="text/css">
        input[type='file']{
            width: 117px;
            height: 102px;
            position: absolute;
            top: 0;
            font-size:0;
            cursor: pointer;
            opacity: 0;
        }
        .display_img{
            float:left;
            position:relative;
            margin-right:30px
        }
        .del{
            position:absolute;
            top:-9px;
            left:110px;
            cursor:pointer;
        }
    </style>
@endsection
@section('header')
@show
@section('content')
    <!--内容区-->
    <div class="container clearfix">
        <ul class="list-group">
            @foreach($items as $item)
                <li class="list-group-item">
                    <a href="{{ route('demand.show', ['id' => $item->id]) }}" target="_blank">
                        <span class="badge">
                                @switch($item->status)
                                    @case(304)
                                        已接单
                                    @break
                                    @case(305)
                                        结算中
                                    @break
                                    @case(306)
                                        已结算, 评价： {{ $item->high_praise }} 分
                                    @break
                                @endswitch
                            </span>
                        {{ $item->title }}
                        <span class="badge">
                            接单人: {{ $item->guser->account .'('.$item->user->number.')'}}
                        </span>
                    </a>
                </li>
                <div style="text-align: right;">
                    {!! $items->links() !!}
                </div>
            @endforeach
        </ul>
    </div>
@endsection
@section('bottom')
@show
@section('shop')
@endsection
@section('js')
    @parent
    <script src="{{ asset('home/js/public.js') }}"></script>
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection
@section('section')

@endsection
