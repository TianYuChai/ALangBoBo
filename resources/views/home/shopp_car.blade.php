@extends('home.public.subject')
@section('title', '购物车列表')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/shopCarList-order.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopCarList-sum.css') }}"/>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--购物车商品列表部分-->
    <div class="container">
        <div class="">
            <div class="clearfix productList">
                <p class="fl titleLeft">全部商品 <span></span></p>
            </div>
            <div class="tableList mgt-20 mgb-300">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="shopping">
                    <form action="" method="post" name="myform"></form>
                    <thead class="orderThead">
                    <tr class="">
                        <th class="col-gray" width="40"><input type="checkbox" class="checkAll"/>全选</th>
                        <th class="col-gray" width="560"> 商品信息</th>
                        <th class="col-gray" width="150">单价</th>
                        <th class="col-gray" width="150">数量</th>
                        <th class="col-gray" width="100"> 金额</th>
                        <th class="col-gray">操作</th>
                    </tr>
                    </thead>
                        <tbody>
                            <!--同一家店铺 不止一个商品-->
                            @foreach($data as $datum)
                            <tr>
                                <td colspan="6" class="shopName pdb-10 pdt-10">
                                    <input type="checkbox" class="mgt-10 merchant_check">店铺：
                                    <span class="mgt-10">{{ $datum['name'] }}[{{ $datum['code'] }}]</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table class="borderTable">
                                        <tbody>
                                        @foreach($datum['data'] as $value)
                                            <tr>
                                                <td class="" width="400">
                                                    <div class="clearfix shopBaby">
                                                        <input type="checkbox" class="fl" name="checkbox" value="{{ $value->id }}"/>
                                                        <img src="{{ FileUpload::url('image', $value->goods->cost_img) }}" alt="" class="fl mgl-10"/>
                                                        <p class="fl">{{ $value->goods->title }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="shopAttr" width="200">
                                                    @foreach($value['goods_attribute'] as $v)
                                                        <p>{{ $v['name'] }}：{{ $v['value'] }}</p>
                                                    @endforeach
                                                </td>
                                                <td class="price" width="150">￥<span>{{ $value->goods->total_price }}</span></td>
                                                <td class="number" width="150">
                                                    <input class="min mgl-20" type="button" value="-"/>
                                                    <input class="text_box" name="text_box" type="text"
                                                           value="{{ $value['few'] }}" data-stock="{{ $value->goods->stocks }}"
                                                           style="width:30px;text-align: center" readonly/>
                                                    <input class="add detailNumInput" type="button" value="+"/>
                                                </td>
                                                <td class="discount totalSum" width="100">￥{{ bcmul($value->goods->total_price , $value['few'], 2) }}</td>
                                                <td class="cart_td_7"><a href="javascript:void(0);" onclick='deleteTr(this,"{{ $value->id }}");'>删除</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </tbody>
                    <tfoot class="">
                    <tr class="tableSum">
                        <td colspan="6">
                            <div  class="clearfix footDiv">
                                <div class="fl footLeft">
                                    <input type="checkbox" class="checkAll inline-block"/>
                                    <span class="inline-block">全选(不参与计算)</span>
                                    <a href="javascript:void(0);" class="clear inline-block mgl-20">删除</a>
                                </div>
                                <div class="fr">
                                    <p class="inline-block mgr-20">已选商品 <span class="jianNum">0</span> 件</p>
                                    <p class="inline-block mgr-20">
                                        <span class="sumText">合计（不含运费）</span>
                                        <span class="sumPrice">￥<span>0.00</span></span>
                                    </p>
                                    <a href="javascript:void(0)" class="sumBtn">结算</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
    <script type="text/javascript">
        let number = 0;
        $(document).ready(function(){
            // 数量加减
            //初始化数量为1,并失效减
            $('.min').attr('disabled',true);
            //数量增加操作
            $(".add").click(function(){
                let t = $(this).prev('input[name="text_box"]');
                let stock = t.data('stock');
                let num = parseInt(t.val())+1;
                // 给获取的val加上绝对值，避免出现负数
                if(num <= stock) {
                    t.val(Math.abs(parseInt(t.val()))+1);
                }
                if (parseInt(t.val())!=1){
                    $('.min').attr('disabled',false);
                };
                let checked = $(this).parent().parent().find('input[name="checkbox"]');
                if(checked.is(':checked')) {
                    let money = $(this).parent().parent().find('.price span').text();
                    let stitis_monery = $('.sumPrice').find('span').text();
                    $('.sumPrice').find('span').text((parseFloat(stitis_monery) + parseFloat(money)).toFixed(2));
                }
            })
            //数量减少操作
            $(".min").click(function(){
                let t = $(this).next('input[name="text_box"]');
                t.val(Math.abs(parseInt(t.val()))-1);
                if (parseInt(t.val())==1){
                    $('.min').attr('disabled',true);
                };
                let checked = $(this).parent().parent().find('input[name="checkbox"]');
                if(checked.is(':checked')) {
                    let money = $(this).parent().parent().find('.price span').text();
                    let stitis_monery = $('.sumPrice').find('span').text();
                    $('.sumPrice').find('span').text((parseFloat(stitis_monery) - parseFloat(money)).toFixed(2));
                }
            });
        });
        //全选点击事件
        $('.checkAll').on('click', function () {
            let partent_status = $(this).is(':checked');
            let stitis_monery = 0;
            let stitis_num = 0;
            $("input[name='checkbox']").each(function () {
                let val = $(this).val();
                let single_monery = $(this).parent().parent().siblings('.price').find('span').text();
                let single_num = $(this).parent().parent().siblings('.number').find('.text_box').val();
                if(Math.abs(val)) {
                    $(this).prop('checked', partent_status);
                    if(partent_status) {
                        stitis_monery = (parseFloat(stitis_monery) + parseFloat(single_monery) * parseInt(single_num)).toFixed(2);
                        stitis_num++;
                    }
                }
            });
            $('.jianNum').text(parseInt(stitis_num));
            $('.sumPrice').find('span').text(stitis_monery);
        });
        //商铺选择
        $('.merchant_check').on('click', function () {
            let partent_status = $(this).is(':checked');
            let inputs = $(this).parent().parent().next().find('input[name="checkbox"]');
            let stitis_monery = 0;
            let stitis_num = 0;
            inputs.each(function () {
                let val = $(this).val();
                let single_monery = $(this).parent().parent().siblings('.price').find('span').text();
                let single_num = $(this).parent().parent().siblings('.number').find('.text_box').val();
                if(Math.abs(val)) {
                    $(this).prop('checked', partent_status);
                    if(partent_status) {
                        stitis_monery = (parseFloat(stitis_monery) + parseFloat(single_monery) * parseInt(single_num)).toFixed(2);
                        stitis_num++;
                    }
                }
            });
            $('.jianNum').text(parseInt(stitis_num));
            $('.sumPrice').find('span').text(stitis_monery);
        });
        //单选数量操作
        $('input[name="checkbox"]').on('click', function () {
            let number = $('.jianNum').text();
            let all_monery = $('.sumPrice').find('span').text();
            let monery = $(this).parent().parent().siblings('.price').find('span').text();
            let num = $(this).parent().parent().siblings('.number').find('.text_box').val();
            if($(this).is(':checked')) {
                $('.jianNum').text(parseInt(number) + 1);
                $('.sumPrice').find('span').text((parseFloat(all_monery) + parseFloat(monery)* parseInt(num)).toFixed(2));
            } else {
                $('.jianNum').text(parseInt(number) - 1);
                $('.sumPrice').find('span').text((parseFloat(all_monery) - parseFloat(monery) * parseInt(num)).toFixed(2));
            }
        });
        //删除操作
        function deleteTr(nowTr, id){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('shopp.shopp.delgoods') !!}",
                data:{ids: id},
                dataType: "json",
                success:function (res) {
                    if(res.status == 200) {
                        $(nowTr).parent().parent().remove();
                        $(this).closest('tr').remove();  //清空当前行
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
                        if(XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(XMLHttpRequest.statusText == 'Unauthorized') {
                            window.location.href = "{{ route('index.login') }}";
                        } else {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                }
            });
        }
        //全选删除
        $(".clear").on('click',function(){
            let ids = [];
            $("input[name='checkbox']").each(function () {
                let val = $(this).val();
                if(Math.abs(val)) {
                    if($(this).is(':checked')) {
                        ids.push(val);
                    }
                }
            });
            if(ids.length < 1) {
                layer.msg('请选择要删除的数据'); return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('shopp.shopp.delgoods') !!}",
                data:{ids: ids},
                dataType: "json",
                success:function (res) {
                    if(res.status == 200) {
                       window.location.reload();
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
                        if(XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(XMLHttpRequest.statusText == 'Unauthorized') {
                            window.location.href = "{{ route('index.login') }}";
                        } else {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                }
            });
        });
        $('.sumBtn').click(function () {
            var obj = [];
            $("input[name='checkbox']").each(function () {
                let val = $(this).val();
                if($(this).is(':checked')) {
                    let num = $(this).parent().parent().siblings('.number').find('.text_box').val();
                    obj.push({id: val, num: num});
                }
            });
            if(obj.length < 1) {
                layer.msg('请选择结算商品');return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('shopp.shopp.shoppsettlement') !!}",
                data:{data: obj},
                dataType: "json",
                success:function (res) {
                    if(res.status == 200) {
                        window.location.href = res.url;
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 429) {
                            layer.msg('请求过快, 请稍后再试');return;
                        }
                        if(XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(XMLHttpRequest.statusText == 'Unauthorized') {
                            window.location.href = "{{ route('index.login') }}";
                        } else {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                }
            });
        });
    </script>
@endsection
