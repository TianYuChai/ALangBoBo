<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="favicon.ico" >
    <link rel="Shortcut Icon" href="favicon.ico" />
    @section('hea')
        @include('admin.public.head')
    @show
    <title>@yield('title', '阿朗博博商务管理中心')</title>
</head>
<body>
    <section class="Hui-admin-article-wrapper">
        @section('header')
            @include('admin.public.header')
        @show
        @section('content')

        @show
    </section>
</body>
</html>


