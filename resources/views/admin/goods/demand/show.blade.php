@extends('admin.public.plugins')
@section('content')
    <div>
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer" style="text-align: center">
            {{ $item->title }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            发布人: {{ $item->user->account }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            接单人: @if($item->guid !=0) {{ $item->guser->account }} @endif
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            展示方式: {{ \App\Http\Models\home\demandModel::$_DISPLAY[$item->display] }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            材料选择: {{ \App\Http\Models\home\demandModel::$_MATERIAL[$item->material] }}
        </blockquote>
    </div>
    <div class="layui-inline" style="margin-bottom: 15px" onclick="imgshow(this, '{{ FileUpload::url("image", $item->img) }}')">
        <img class="layui-circle"
             src="{{ FileUpload::url("image", $item->img) }}" style="width: 117px; height: 80px">
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            价格: {{ $item->moneys }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            成本: {{ $item->cost_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            满意度价格: {{ $item->poundage_price }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            工作时长: {{ $item->time }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            其他要求: {{ $item->other }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            退款时长: {{ $item->refund_timeout }} 天
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            支付: {{ \App\Http\Models\currency\CapitalModel::$_TRADEMODE[$item->pay_method] }} : {{ $item->order_id }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            状态: <span style="color: red"> {{ $item->status_name }}</span>
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            好评度: {{ $item->high_praise }} 分
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            描述: <br/>
            {!! $item->describe !!}
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
