@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-商品管理')
@section('css')
    @parent
    <link href="https://cdn.bootcss.com/twitter-bootstrap/3.4.1/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        tr td {
            text-align: left;
        }
    </style>
@endsection
@section('header')
@endsection
@section('content')
    <div class="table-responsive" style="width: 990px">
        <table class="table">
            <thead>
            <tr>
                <th>属性</th>
                <th>内容</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>订单号</td>
                <td>{{ $item->order_id }}</td>
            </tr>
            <tr>
                <td>购买者</td>
                <td>{{ $item->user->account }}</td>
            </tr>
            <tr>
                <td>商铺</td>
                <td>{{ $item->merchant->shop_name }}</td>
            </tr>
            <tr>
                <td>商品名称</td>
                <td>{{ $item->goodss->title }}</td>
            </tr>
            <tr>
                <td>属性</td>
                <td>
                    @foreach($item->goodss->attribute as $attribute)
                        <p>{{ $attribute->name }}：<span>{{ $attribute->value }}</span></p>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>价格</td>
                <td>
                    {{ $item->moneys }} <br>
                    @if($item->moneys > $item->free_price)
                        <p>包邮</p>
                    @else
                        <p>（含运费：￥{{ $item->delivery_fees }}）</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td>满意度价</td>
                <td>
                    {{ $item->satisfied_fees }}
                </td>
            </tr>
            <tr>
                <td>单价</td>
                <td>{{ $item->fees }}</td>
            </tr>
            <tr>
                <td>数量</td>
                <td>{{ $item->num }}</td>
            </tr>
            <tr>
                <td>支付类型</td>
                <td>
                    {{ $item->pay_methods }} <br>
                    @if($item->pay_method != 200 && $item->pay_method == 'subscribed'
                                                    && $item->timeout != '0000-00-00 00:00:00')
                        <span style="color: red">认缴单, 未付款</span>
                        <br>
                        <span>自动结算倒计时：{{ $item->settle_subscribed }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>订单状态</td>
                <td>{{ $item->status_name }}</td>
            </tr>
            <tr>
                <td>收货地址</td>
                <td>
                    省市区: {{ $item->addresss->address }} <br>
                    信息: {{ $item->addresss->detailed }} <br>
                    邮编: {{ $item->addresss->code }} <br>
                    收货人: {{ $item->addresss->contacts }} <br>
                    收货人号码: {{ $item->addresss->number }}
                </td>
            </tr>
            <tr>
                <td>订单备注</td>
                <td>{{ $item->memo }}</td>
            </tr>
            @if($item->status > 300 && $item->status < 700)
                <tr>
                    <td>订单快递</td>
                    <td>
                        快递：{{ $item->courier_firm }} <br>
                        快递单号：{{ $item->courier_code }}
                    </td>
                </tr>
            @endif
            @if(in_array($item->status, [700, 800, 900]))
                <tr>
                    <td>退款</td>
                    <td>
                        订单进入<span style="color:red ">{{ $item->status_name }}</span>, 退款理由：{{ $item->refund }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
@section('shop')
@endsection
@section('bottom')
@endsection
@section('js')
    @parent
@endsection
@section('section')

@endsection
