@extends('home.public.subject')
@section('title', '阿朗博波-分享推广-推广管理')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/common/base.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_shopSign.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_bannerList.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/distpicker/2.0.3/distpicker.js"></script>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <!--内容区-->
    <div class="container clearfix">
        <!--左边菜单栏-->
        <div class="fl mgt-30">
            <ul class="shLeftNav">
                @include('home.personal.personal')
                <li class="firstLevel">
                    <p>店铺管理</p>
                    <ul>
                        <li>
                            <a href="{{ route('personal.shop.index') }}" >店招更换</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.menu') }}">导航菜单栏</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.banner') }}">店铺轮播</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.goods') }}">商品管理</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.partime.index') }}">兼职管理</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.shop.order', ['type' => 'allOrder']) }}">订单管理</a>
                        </li>
                    </ul>
                </li>
                <li class="firstLevel">
                    <p>分享推广</p>
                    <ul>
                        <li>
                            <a href="{{ route('personal.shop.generalize') }}" class="leftNavActive">推广管理</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--右边内容区-->
        <div class="fl mgt-30">
            <div class="shInfoTittle">
                <p>推广管理</p>
            </div>
            <div class="shInfoDiv">
                <div class="bs-example" data-example-id="simple-table">
                    <table class="table">
                        <caption>
                            <form class="form-inline" method="get">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           id="exampleInputName2" name='keyword' placeholder="请输入推广id" value="{{ Input::get('keyword', '') }}">
                                </div>
                                <button type="submit" class="btn btn-default">搜索</button>
                                <div style="float: right;">
                                    <button type="button" class="btn btn-primary add">获取分享链接</button>
                                </div>
                            </form>
                        </caption>
                        <thead>
                        <tr>
                            <th width="60px">链接ID</th>
                            <th>分享名称</th>
                            <th>订单数</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <th scope="row" id="share">
                                    {{ route('merchant.show', ['id' => Auth::guard('web')->user()->merchant['id']]).'?referess='.$item->share_id }}
                                </th>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <span class="text-danger">{{ $item->statistics->where('status', 500)->count() }}</span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" id="copy">复制</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: right;">
                        {!! $items->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
    <script type="text/javascript">
        $('.add').click(function () {
            layer.prompt({title: '请输入分享者的名称作为展示数据的展示名', formType: 2}, function(text, index){
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"POST",
                    url:"{!! route("personal.generalize.store") !!}",
                    data:{name: text},
                    success:function (res) {
                        if(res.status == 200) {
                            layer.alert(res.url, {
                                 skin: 'layui-layer-molv'
                                ,closeBtn: 0
                                ,title: '分享连接'
                            });
                        }
                    },
                    error:function (XMLHttpRequest) {
                        //返回提示信息
                        try {
                            var errors = XMLHttpRequest.responseJSON.errors;
                            for (var value in errors) {
                                layer.msg(errors[value][0]);return;
                            }
                        } catch (e) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                });
            });
        });
        $('#copy').click(function () {
            let val = $.trim($(this).parent().siblings('#share').text());
            var flag = copyText(val); //传递文本
            if(flag) {
                layer.msg('复制成功');
            }
        });
        function copyText(text) {
            var textarea = document.createElement("input");//创建input对象
            var currentFocus = document.activeElement;//当前获得焦点的元素
            document.body.appendChild(textarea);//添加元素
            textarea.value = text;
            textarea.focus();
            if(textarea.setSelectionRange)
                textarea.setSelectionRange(0, textarea.value.length);//获取光标起始位置到结束位置
            else
                textarea.select();
            try {
                var flag = document.execCommand("copy");//执行复制
            } catch(eo) {
                var flag = false;
            }
            document.body.removeChild(textarea);//删除元素
            currentFocus.focus();
            return flag;
        }
    </script>
@endsection
