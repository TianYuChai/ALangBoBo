<!DOCTYPE html>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">-->
<html lang="zh-CN">
<head>
    <meta name="renderer" content="webkit">
    <!--<meta http-equiv="X-UA-Compatible" content="9">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '阿郎博波    将经历和体验做出产品')</title>
    @section('css')
        @include('home.public.public_css')
    @show
</head>
<body class="bg-white">
    <div class="relative">
        {{--@section('header_img')--}}
            {{--<div class="topDiv">--}}
                {{--<img src="{{ asset('home/images/img/firstImg.png') }}" alt=""/>--}}
            {{--</div>--}}
        {{--@show--}}
        {{--导航栏--}}
        @section('header')
            @include('home.public.header')
        @show
        {{--内容栏--}}
        @yield('content')
        {{--底部--}}
        @section('bottom')
            @include('home.public.bottom')
        @show
        {{--侧边栏--}}
        @section('shop')
            @include('home.public.shop')
        @show
    </div>
</body>
@section('js')
    @include('home.public.public_js')
@show
@yield('section')
</html>
