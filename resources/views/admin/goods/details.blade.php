@extends('admin.public.plugins')
@section('content')
    <div>
       <blockquote class="layui-elem-quote layui-quote-nm" id="footer" style="text-align: center">
           {{ $item->title }}
       </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            商品状态: {{ $item->status_name }}
        </blockquote>
    </div>
    <div class="layui-inline" style="margin-bottom: 15px" onclick="imgshow(this, '{{ FileUpload::url("image", $item->cost_img) }}')">
        <img class="layui-circle"
             src="{{ FileUpload::url("image", $item->cost_img) }}" style="width: 117px; height: 80px">
    </div>
    <div class="layui-tab-item layui-show">
        <div class="layui-carousel" id="test1">
            <div carousel-item>
                @foreach($item->shuff_img as $img)
                    <div>
                        <img src="{{ FileUpload::url('image', $img->img) }}" style="width: 946px; height: 200px">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            导航分类: {{ $item->merchat_category }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            商品分类: {{ $item->goods_category }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            商品属性: <br/>
            @foreach($item->attributes as $key => $value)
                <span>
                    {{ $key }} :
                    @foreach($value as $v)
                        {{ $v['value'] }}
                    @endforeach
                </span> <br/>
            @endforeach
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            发货地址: {{ !empty($item->addresss) ? $item->addresss->address : '' }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            总价: {{ $item->total_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            成本: {{ $item->cost_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            满意度: {{ $item->satic_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            运费(为空，默认包邮): {{ $item->delivery_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            包邮: {{ $item->free_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            库存: {{ $item->stocks }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            已售: {{ $item->sold }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            新品: {{ $item->new_goods == 1 ? '是' : '否' }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            详情: <br/>
            {!! $item->content !!}
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
