@extends('admin.public.plugins')
@section('content')
    <div>
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer" style="text-align: center">
            店铺名称：{{ $item->shop_name }}
        </blockquote>
    </div>
    <div class="layui-inline"
         onclick="imgshow(this, '{{ FileUpload::url("image", $item->trademark) }}')">
        商标: <img class="layui-circle"
             src="{{ FileUpload::url("image", $item->trademark) }}" style="width: 117px; height: 80px">
    </div>
    <br/>
    <div class="layui-inline"
         onclick="imgshow(this, '{{ FileUpload::url("image", $item->qr_code) }}')">
        二维码: <img class="layui-circle"
                 src="{{ FileUpload::url("image", $item->qr_code) }}" style="width: 117px; height: 80px">
    </div>
    <br>
    <div>
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer" style="text-align: center">
            店铺类别：{{ $item->dist_name }}
        </blockquote>
    </div>
    <div>
        <blockquote class="layui-elem-quote layui-quote-nm" id="footer">
            店铺导航分类：
            <br/>
            @foreach($item->categorys as $category)
                {{ $category->name }} (状态：{{ $category->StatusName }}) <br/>
            @endforeach
        </blockquote>
    </div>
    <div>
        店铺Banner图：
        <div class="layui-tab-item layui-show">
            <div class="layui-carousel" id="test1">
                <div carousel-item>
                    @foreach($item->img as $img)
                        <div>
                            <a href="{{ $img->url }}" target="_blank">
                                <img src="{{ FileUpload::url('image', $img->image) }}" style="width: 946px; height: 200px">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
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
