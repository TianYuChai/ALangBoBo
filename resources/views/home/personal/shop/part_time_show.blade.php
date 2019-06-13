@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-兼职投递记录')
@section('header')
    @section('css')
        @parent
        <style type="text/css">
            tr td{
               text-align: left;
            }
        </style>
    @endsection
@endsection
@section('content')
    <div class="bs-example" data-example-id="simple-table">
        <table class="table" style="width: 950px">
            <thead>
            <tr>
                <th>投递人</th>
                <th>投递人号码</th>
                <th>投递时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($item->send as $value)
                <tr>
                    <td>{{ $value->user->account }}</td>
                    <td>{{ $value->user->number }}</td>
                    <td>{{ $value->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('shop')
@endsection
@section('bottom')
@endsection
