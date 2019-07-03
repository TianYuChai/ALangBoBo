@extends('home.public.subject')
@section('title', '详情-'.$item->title)
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/experience-detail.css') }}"/>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <!--内容部分-->
    <div class="container">
        <p class="detailTip mgt-20">百录倩影 > {{ $item->title }} </p>
        <div class="clearfix mgt-20">
            <img src="{{ FileUpload::url('image', $item->img) }}" alt="" class="fl experienceProduct"/>
            <div class="fl productInfo">
                <p class="infoTittle">{{ $item->title }}</p>
                <p class="infoDetail">
                    {{ $item->describe }}
                </p>
                @switch($item->status)
                    @case(303)
                        <a href="javascript:void(0)" class="receipt order">接单</a>
                    @break
                    @case(304)
                        <span class="receipt">已接单</span>
                    @break
                    @case(305)
                        <span class="receipt">已接单</span>
                    @break
                    @case(306)
                        <span class="receipt">已结单</span>
                    @break
                    @break
                @endswitch
            </div>
            <div class="fr experienceCodeDiv">
                <div class="experienceCode">
                    @if(!empty($item->user->merchant->qr_code))
                        <img src="{{ FileUpload::url('image', $item->user->merchant->qr_code) }}" alt=""/>
                    @else
                        <span>{{ $item->user->number }}</span>
                    @endif
                </div>
                <p class="saoyisao">[联系发布者]</p>
            </div>
        </div>
        <div class="productAttr mgt-30">
            <ul class="productAttrUl">
                <li>
                    <p>价格:</p>
                    <ul class="clearfix attrList">
                        <li>
                            <p>总价：<span class="inline-block experiencePrice">{{ $item->moneys }}</span>元</p>
                        </li>
                        <li>
                            <p>成本价：<span class="inline-block experiencePrice">{{ $item->cost_price }}</span>元</p>
                        </li>
                        <li>
                            <p>满意度价格：<span class="inline-block experiencePrice">{{ $item->satisfaction_price }}</span>元</p>
                        </li>
                        <li>
                            <p>手续费：<span class="inline-block experiencePrice">{{ $item->poundage_price }}</span>元</p>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="productAttrUl">
                <li class="showStyle">
                    <p>表现形式选择:</p>
                    <ul class="clearfix attrList">
                        @foreach(\App\Http\Models\home\demandModel::$_DISPLAY as $key => $display)
                            <li class="{{ $key == $item->display ? 'showStyleActive' : '' }}">
                                <p>{{ $display }}</p>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <ul class="productAttrUl">
                <li class="showStyle ">
                    <p>材料选择:</p>
                    <ul class="clearfix attrList">
                        @foreach(\App\Http\Models\home\demandModel::$_MATERIAL as $k => $material)
                            <li class="{{ $k == $item->material ? 'showStyleActive' : '' }}">
                                <p>{{ $material }}</p>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <ul class="productAttrUl">
                <li class="showStyle ">
                    <p>其他:</p>
                    <ul class="clearfix attrList">
                        <li class="showStyleActive">
                            <p>{{ $item->other }}</p>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="productAttrUl">
                <li class="showStyle ">
                    <p>时间:</p>
                    <ul class="clearfix attrList">
                        <li class="showStyleActive">
                            <p>{{ $item->time }}天</p>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--详情-->
        <div class="textRecord mgt-50">
            <p class="mgb-20">详情</p>
            <!--此为占位，具体内容具体添加-->
            <div class="clearfix mgt-30">
                {!! $item->content !!}
            </div>
        </div>
    </div>
@endsection
@section('section')
    <script type="text/javascript">
        $('.order').click(function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"get",
                url:"{{ route("demand.send", ['id' => $item->id]) }}",
                data:'',
                success:function (res) {
                    if(res.status == 200) {
                        window.location.reload();
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(XMLHttpRequest.statusText == 'Unauthorized') {
                            window.location.href = "{{ route('index.login') }}";
                        } else {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                }
            });
        });
    </script>
@endsection
