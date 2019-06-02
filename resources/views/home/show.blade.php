@extends('home.public.subject')
@section('title', "$item->title")
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/productDetail-clothes.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/productDetail-aAdvanceSale.css') }}"/>
    <link href="{{ asset('home/common/pagination.css') }}" rel="stylesheet">
    <script src="{{ asset('home/js/jquery.pagination.js') }}"></script>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container">
        <!--内容上部分-->
        <div class="contentTop clearfix">
            <div class="fl contentTopLeft">
                <div class="fangdaImgDiv picture_img">
                    <a href="javascript:void(0)" class="picture_img2">
                        <img src="{{ FileUpload::url('image', $item->shuffimg[0]->img) }}" class="clothesImgBig showImg"/>
                    </a>
                </div>
                <ul class="clearfix mgt-10 picture_suo clothesImgUl">
                    @foreach($item->shuffimg as $img)
                        <li class="picture_suo_img suo-img pointer">
                            <div class="inline-block">
                                <img src="{{ FileUpload::url('image', $img->img) }}" class="lazy"/>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="fl contentTopRight relative">
                <p class="clothesName pdl-10">{{ $item->title }}</p>
                @if($item->presell_time)
                    <p class="advanceSaleTip">
                        <img src="{{ asset('home/images/icon/advanceSaleIcon.png') }}" alt=""/>
                        预售商品, 出售日期：{{ $item->presell_time }}
                    </p>
                @endif
                <div class="clothesPriceDiv">
                    <p class="clothesTotalPrice">总价 <span class="col-black mgl-30">￥{{ $item->total_price }}</span></p>
                    <div class="">
                        <p class="inline-block">成本价
                            <span class="font-30 col-red mgl-20">
                                <span class="font-16">￥</span>{{ $item->cost_price }}
                            </span>
                        </p>
                        <p class="inline-block mgl-20">满意度价
                            <span class="font-30 col-red mgl-20">
                                <span class="font-16">￥</span>{{ $item->satic_price }}
                            </span>
                        </p>
                    </div>
                </div>
                <p class="productAttrFont mgt-20 pdl-10">发货地址
                    <span class="col-black mgl-30">{{ $item->addresss->address }}</span>
                </p>
                <p class="productAttrFont mgt-20 pdl-10">运费
                    <span class="col-black mgl-30"></span>
                    <span class="col-black">
                        @if($item->delivery_price)
                            {{ $item->delivery_price }}
                        @else
                            包邮
                        @endif
                    </span>
                </p>
                @if($item->free_price)
                    <p class="productAttrFont mgt-20 pdl-10">包邮
                        <span class="col-black mgl-30">需满</span>
                        <span class="col-black">
                            {{ $item->free_price }}
                        </span>
                    </p>
                @endif
                @foreach($item->attributes as $key => $attributes)
                    <ul class="pdl-10 mgt-20 attribute">
                        <li>
                            <span class="productAttrFont attrWidth mgt-10">{{ $key }}</span>
                            <ul class="sizeAttrList clearfix">
                                @foreach($attributes as $k => $attribute)
                                    <li class="@if($k == 0) sizeActive @endif sizeBtn" data-id="{{ $attribute['id'] }}">
                                        <p>{{ $attribute['value'] }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                @endforeach
                <ul class="clearfix mgt-20 detailNum pdl-10">
                    <li class="fl fontStyle mgr-20 productAttrFont">数量</li>
                    <li class="mgr-10 fl">
                        <input id="min" type="button" value="-" class="mgl-10 detailNumInput"/>
                        <input id="text_box" type="text" value="1" style="width:30px;text-align: center" readonly/>
                        <input id="add" type="button" value="+" class="detailNumInput"/>
                    </li>
                    <li class="fl">
                        <p class="kucun">当前库存 <span>{{ $item->stocks }}</span></p>
                    </li>
                </ul>
                <div class="pdl-10 productAttrFont mgt-20 buyWayDiv">
                    <span class="mgr-10">购买方式</span>
                    <input type="radio" name="buyWay" value="subscribed"/>认缴
                    <input type="radio" name="buyWay" class="shijiao" value="paidin"/>实缴
                </div>
                <div class="mgt-30 buyBtn">
                    @if(!$item->presell_time || $item->presell_time < getTime())
                        <a href="javascript:void(0)" class="buyNow">立即购买</a>
                    @endif
                    <a href="javascript:void(0)" class="addCar relative addshop"><i></i>加入购物车</a>
                </div>
            </div>
        </div>
        <!--内容下部分-->
        <div class="contentBottom clearfix">
            <div class="contentBottomL fl">
                <img src="{{ asset('home/images/img/shopRecommd.png') }}" alt="" class="recommend"/>
                <ul class="recommendList">
                    @foreach($recom_goods as $recom_good)
                        <li class="">
                            <a href="{{ url('details', ['id' => $recom_good->id]) }}" class="block relative">
                                <img src="{{ FileUpload::url('image', $recom_good->cost_img) }}" alt="" class="recommendImg"/>
                                <p class="recommendPrice">￥{{ $recom_good->total_price }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="contentBottomR mgl-30 fl">
                <div class="contentDetail">
                    <p class="relative"> <i></i>商品详情</p>
                </div>
                {!! $item->content !!}
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
        //点击缩略图显示大图
        $(document).ready(function(){
            var src = $(".picture_suo_img img").eq(0).attr('src');
            $('.showImg').attr('src', src);
        });

        /*获取缩略图的地址传到div形成大图*/
        $('.picture_suo_img img').each(function() {
            $(this).click(function() {
                var src = $(this).attr('src');
                $('.showImg').attr('src', src);
            });
        });
        /*点击切换缩略图*/
        $(".picture_suo_img").click(function() {
            $(".picture_suo_img").siblings(".suo-img").removeClass('suo-img');
            $(this).addClass('suo-img');
        });
        // 尺码选择状态效果detailBedLi
        $(".sizeBtn").on('click',function(){
            $(this).siblings().removeClass('sizeActive');
            $(this).addClass('sizeActive');
        });

        $(document).ready(function(){
            // 数量加减
            //获得文本框对象
            var t = $("#text_box");
            //初始化数量为1,并失效减
            $('#min').attr('disabled',true);
            //数量增加操作
            $("#add").click(function(){
                // 给获取的val加上绝对值，避免出现负数
                let number = Math.abs(parseInt(t.val()))+1;
                if(number <= "{{ $item->stocks }}") {
                    t.val(Math.abs(parseInt(t.val()))+1);
                }
                if (parseInt(t.val())!= 1){
                    $('#min').attr('disabled',false);
                };
            })
            //数量减少操作
            $("#min").click(function(){
                t.val(Math.abs(parseInt(t.val()))-1);
                if (parseInt(t.val())==1){
                    $('#min').attr('disabled',true);
                };
            })
        });
        $(".tipDeleteBtn").on('click',function(){
            $('.bitianModal').addClass('hidden');
        });
        
        $('.buyNow').click(function () {
            var obj = {};
            var attribute = [];
            $('.sizeActive').each(function () {
                attribute.push($(this).data('id'));
            });
            obj['attribute'] = attribute;
            obj['num'] = $('#text_box').val();
            $('input[name="buyWay"]').each(function () {
                if($(this).is(':checked')) {
                    obj['pay_method'] = $(this).val();
                }
            });
            if(!obj['pay_method']) {
                layer.msg('请选择付款方式'); return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('shopp.shopp.buynow', ['id' => $item->id]) !!}",
                data:obj,
                dataType: "json",
                success:function (res) {
                    if(res.status == 200) {
                        window.location.href = res.url;
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
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
        $('.addshop').click(function () {
            var obj = {};
            var attribute = [];
            $('.sizeActive').each(function () {
                attribute.push($(this).data('id'));
            });
            obj['attribute'] = attribute;
            obj['num'] = $('#text_box').val();
            $('input[name="buyWay"]').each(function () {
                if($(this).is(':checked')) {
                    obj['pay_method'] = $(this).val();
                }
            });
            if(!obj['pay_method']) {
                layer.msg('请选择付款方式'); return false;
            }
            console.log(obj);
        });
    </script>
@endsection
