@extends('admin.public.plugins')
@section('content')
    <div>
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            商铺名称: {{ $item->merchant->shop_name }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            购买人: {{ $item->user->account }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            订单选购类别:
            {{ $item->pay_methods }} <br>
            @if($item->pay_method != 200 && $item->pay_method == 'subscribed'
                                            && $item->timeout != '0000-00-00 00:00:00')
                <span style="color: red">认缴单, 未付款</span>
                <br>
                <span>自动结算倒计时：{{ $item->settle_subscribed }}</span>
            @endif
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            订单号: {{ $item->order_id }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            价格:
            {{ $item->moneys }}
            @if($item->moneys > $item->free_price)
                <p>包邮</p>
            @else
                <p>（含运费：￥{{ $item->delivery_fees }}）</p>
            @endif
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            满意度价: {{ $item->satisfied_fees }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            数量: {{ $item->num }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            单价: {{ $item->fees }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            商品名称: {{ $item->goodss->title }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            商品属性:
            @foreach($item->goodss->attribute as $attribute)
                <p>{{ $attribute->name }}：<span>{{ $attribute->value }}</span></p>
            @endforeach
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            订单状态: <br/>

        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            订单备注: <br/>
            {{ $item->memo }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            收货地址: <br/>
            @if($item->addresss)
                省市区: {{ $item->addresss->address }} <br>
                信息: {{ $item->addresss->detailed }} <br>
                邮编: {{ $item->addresss->code }} <br>
                收货人: {{ $item->addresss->contacts }} <br>
                收货人号码: {{ $item->addresss->number }}
            @endif
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            订单状态: <br/>
            {{ $item->status_name }} <br>
            @if($item->status > 300 && $item->status < 700)
                订单快递: <br>
                快递：{{ $item->courier_firm }} <br>
                快递单号：{{ $item->courier_code }} <br>
            @endif
            @if(in_array($item->status, [700, 800, 900]))
                退款: <br>
                订单进入<span style="color:red ">{{ $item->status_name }}</span>, 退款理由：{{ $item->refund }}<br>
            @endif
            @if($item->evaluation)
                评价:<br>
                满意度: {{ $item->evaluation->satisfaction }}% <br>
                商品评价: {{ $item->evaluation->goods_evaluation }} <br>
                服务评价: {{ $item->evaluation->service_evaluation }} <br>
                评价图片：
                @if(!empty($item->evaluation->images))
                    @foreach(json_decode($item->evaluation->images) as $img)
                        <img src="{{ FileUpload::url('image', $img) }}" class="fl">
                    @endforeach
                @endif
            @endif
        </blockquote>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        layui.use(['layer', 'jquery', 'carousel'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                carousel = layui.carousel;
            //执行一个轮播实例
            carousel.render({
                elem: '#test1'
                ,width: '100%' //设置容器宽度
                ,height: 200
                ,arrow: 'none' //不显示箭头
                ,anim: 'fade' //切换动画方式
            });
            window.imgshow = function (obj, url) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: ['350px', '350px'],
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: '<img src="'+url+'">'
                });
            }
        })
    </script>
@endsection
