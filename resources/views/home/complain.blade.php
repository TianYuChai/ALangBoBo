@extends('home.public.subject')
@section('title', '黑名单公示')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/blackList-public.css') }}"/>
    <link href="{{ asset('home/common/pagination.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container">
        <div class="blacklistTop">
            <span class="borderLeft"></span>
            <p class="blacklistTip">投诉与建议公示</p>
        </div>
        <div>
            <ul id="myTab" class="nav nav-tabs shopCarList">
                <li class="active">
                    <a href="#blackList-sj" data-toggle="tab">
                        投诉与建议
                    </a>
                </li>
                {{--<li class="borderRight"></li>--}}
                {{--<li class="">--}}
                    {{--<a href="#blackList-mj" data-toggle="tab">买家黑名单</a>--}}
                {{--</li>--}}
            </ul>
            <div id="myTabContent" class="tab-content relative">
                <!--tab1 商家黑名单-->
                <div class="tab-pane fade in active" id="blackList-sj">
                    <!--黑名单内容不限-->
                    {{--<a href="" class="publishList-sj" data-toggle="modal" data-target="#publishList-sj">发布黑名单</a>--}}
                    <ul class="blackListUl-sj clearfix">
                        @foreach($items as $item)
                            <li>
                               <p>
                                   公示:
                                   <span>
                                       {{ $item->name == 0 ?  $item->buser->merchant->shop_name : $item->buser->account }}
                                   </span>
                               </p>
                                <p>
                                    公式类别:
                                    <span>
                                        {{ $item->name == 0 ? '商家': '用户' }}
                                    </span>
                                </p>
                                <p>
                                    公示原因:
                                    <span>
                                        {{ $item->content }}
                                    </span>
                                </p>
                                <p>
                                    处理结果:
                                    <span>
                                        {{ $item->result }}
                                    </span>
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tc paginationDiv">
                    {!! $items->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
