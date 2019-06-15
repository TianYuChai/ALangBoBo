@extends('admin.public.plugins')
@section('content')
    <div>
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer" style="text-align: center">
            {{ $item->title }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            分类: {{ $item->category_name }}
        </blockquote>
    </div>
    <div class="layui-inline" style="margin-bottom: 15px" onclick="imgshow(this, '{{ FileUpload::url("image", $item->image) }}')">
        <img class="layui-circle"
             src="{{ FileUpload::url("image", $item->image) }}" style="width: 117px; height: 80px">
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            价格: {{ $item->moneys }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            薪资结算方式: {{ $item->settles }}
        </blockquote>
    </div>
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            工作时长: {{ $item->time }}
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
    <div style="margin-top: 10px">
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            投递记录:
            @foreach($item->send as $send)
                <span>{{ $send->user->account }}</span> <br>
            @endforeach
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
