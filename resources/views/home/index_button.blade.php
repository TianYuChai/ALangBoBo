@extends('home.public.subject')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/css/blackList-public.css') }}"/>
    <link href="{{ asset('home/common/pagination.css') }}" rel="stylesheet">

@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container" style="text-align: center">
        @if(!is_null($item))
        <h1>{{ $item->title }}</h1>
        <p style="text-align: right; font-size: 11px;color: #4e555b">
            <span>{{ \App\Http\Models\setup\shoppDuiteModel::$_CATEGORY[$item->category_id] }}</span>
            <span>{{ $item->created_at }}</span>
        </p>
        <div class="content">
            {!! $item->content !!}
        </div>
        @endif
    </div>
@endsection
@section('shop')
@endsection
@section('section')
@endsection