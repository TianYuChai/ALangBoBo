<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '阿朗博博商务管理中心')</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    @section('hea')
        @include('admin.public.head')
    @show
</head>

<body>
    @section('header')
    @show
    @section('sidebar')
    @show
    @yield('content')
    {{--@show--}}
    @section('inject')
        @include('admin.public.inject')
    @show
    @section('script')
        @include('admin.public.script')
    @show
    <ul class="rightMenu" id="rightMenu">
        <li data-type="fresh">刷新</li>
        <li data-type="current">关闭当前</li>
        <li data-type="other">关闭其它</li>
        <li data-type="all">关闭所有</li>
    </ul>
</body>
</html>
