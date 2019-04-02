@extends('admin.public.plugins')
@section('content')
<table class="layui-table">
    <thead>
    <tr>
        <th colspan="2" scope="col">
            <p>本次登录IP：{{ $_SERVER['REMOTE_ADDR'] }}</p>
            <p>本次登录时间：{{ date('Y-m-d H:i:s', time()) }}</p>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>服务器域名</td>
        <td>{{ $_SERVER["HTTP_HOST"] }}</td>
    </tr>
    <tr>
        <td>服务器IP地址</td>
        <td>{{ GetHostByName($_SERVER['SERVER_NAME']) }}</td>
    </tr>
    </tbody>
</table>
@endsection
