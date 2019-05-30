@extends('home.public.subject')
@section('title', '提交订单')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/shopCarList-order.css') }}"/>
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--收货地址-->
    <div class="container mgb-300">
        <div class="sureAddress">
            <div class="clearfix addressText">
                <P class="fl">确认收货地址：</P>
                <a class="fr">管理收货地址</a>
            </div>
            <div class="clearfix mgt-20">
                <p class="fl sendTo">寄送至</p>
                <ul class="fl addressList">
                    @foreach($data['address'] as $address)
                        <li class="addressActive">
                            <input type="radio" name="address" @if($address->status == 702) checked @endif/>
                            <p class="mgl-10">{{ $address->address .' '.$address->detailed }}
                                <span>{{ $address->contacts.'('.$address->number .')' }}</span>
                                @if($address->status == 702)
                                    <span>默认地址</span>
                                @endif
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
            <a href="javascript:void(0)" class="newAddressBtn" data-toggle="modal" data-target="#changeSign-jm">
                <img src="{{ asset('home/images/img/newAddressBtn.png') }}"/>
            </a>
        </div>
        <div class="modal fade" id="changeSign-jm" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel-jm" aria-hidden="true">
            <div class="modal-dialog modalWidth">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel-jm">
                            <p class="changeContentTip">
                                <img src="{{ asset('home/images/icon/changeContentIcon.png') }}" />新增地址</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="changeContent">
                            <form class="changeSignForm" id="sendForm">
                                <fieldset class="fieldset clearfix">
                                    <div class="form-group" style="height: 15px;">
                                        <label for="inputEmail3" class="col-sm-2 control-label">地址信息</label>
                                        <div data-toggle="distpicker" class="col-sm-10 distpicker inline-block">
                                            <div class="inline-block sendFormaddress">
                                                <select data-name="eprovince" data-province="- 省份 -" class="outline"></select>
                                            </div>
                                            <div class="inline-block sendFormaddress">
                                                <select data-name="city" data-city="-市/区 -" class="outline"></select>
                                            </div>
                                            <div class="inline-block sendFormaddress">
                                                <select data-name="district" data-district="- 县/市/区 --" class="outline"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">详细地址</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="3" name="detailed"
                                                      placeholder="请输入详细地址信息，如道路、门牌号、小区、楼栋号、单元等信息"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top: 115px;">
                                        <label for="inputEmail3" class="col-sm-2 control-label">邮政编码</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="postNum" name="code" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top: 155px;">
                                        <label for="inputEmail3" class="col-sm-2 control-label">收货人姓名</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="contacts" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top: 205px;">
                                        <label for="inputEmail3" class="col-sm-2 control-label">手机号码</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top: 255px">
                                        <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" name="status" value="1">默认地址
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="button" class="btn btn-primary addressSave">
                            确定
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <div class="sureOrder">
            <p class="orderText">确认订单信息</p>
            <div class="tableList mgt-20">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="shopping">
                    <form action="" method="post" name="myform"></form>
                    <thead class="orderThead">
                    <tr class="border-bottom">
                        <th class="col-gray" width="400">店铺宝贝</th>
                        <th class="col-gray" width="200"> 商品属性</th>
                        <th class="col-gray" width="150">单价</th>
                        <th class="col-gray" width="150">数量</th>
                        <th class="col-gray" width="100"> 优惠方式</th>
                        <th class="col-gray">小计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="6" class="shopName pdb-10 pdt-10"><input type="checkbox" class="mgt-10">店铺：<span class="mgt-10">d[265324578]</span></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table class="borderTable">
                                <tbody>
                                <tr>
                                    <td class="shopBabyTd" width="400">
                                        <div class="clearfix shopBaby">
                                            <input type="checkbox" class="fl"/>
                                            <img src="../images/img/carProduct.png" alt="" class="fl mgl-10"/>
                                            <p class="fl">慵懒风毛衣开衫粗线中长款宽松韩版加厚chic麻花复古温柔风外套女
                                            </p>
                                        </div>
                                    </td>
                                    <td class="shopAttr" width="200">
                                        <p>颜色分类： 驼色</p>
                                        <p>尺码： 均码</p>
                                    </td>
                                    <td class="price" width="150">￥100.40</td>
                                    <td class="number" width="150">2</td>
                                    <td class="discount" width="100">无优惠</td>
                                    <td class="totalSum">￥200.80</td>
                                </tr>
                                <tr>
                                    <td class="shopBabyTd" width="400">
                                        <div class="clearfix shopBaby">
                                            <input type="checkbox" class="fl"/>
                                            <img src="../images/img/carProduct.png" alt="" class="fl mgl-10"/>
                                            <p class="fl">慵懒风毛衣开衫粗线中长款宽松韩版加厚chic麻花复古温柔风外套女
                                            </p>
                                        </div>
                                    </td>
                                    <td class="shopAttr" width="200">
                                        <p>颜色分类： 驼色</p>
                                        <p>尺码： 均码</p>
                                    </td>
                                    <td class="price" width="150">￥100.40</td>
                                    <td class="number" width="150">2</td>
                                    <td class="discount" width="100">无优惠</td>
                                    <td class="totalSum">￥200.80</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="message fl">
                        <span>给卖家留言：</span>
                        <input type="text"/>
                    </div>
                    <p class="sendWay">运送方式 ：普通配送  快递 <span class="mgl-20">￥15.00</span></p>
                </div>
                <div class="fr tr pdr-10">
                    <p class="sendPrice">￥15.00</p>
                    <p class="allSum">店铺合计（含运费） <span class="mgl-20">￥305.40</span></p>
                    <p class="realPrice">实付款：<span class="mgl-20">￥415.80</span></p>
                    <div class="fr mgt-10">
                        <a href="" class="inline-block"><img src="../images/img/backShopCar.png" alt="" class="backBtn"/></a>
                        <a href="" class="submitOrder">提交定单</a>
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
    var check = false;
    //    点击切换选中地址事件
    $(".addressList li").on('click', function () {
        $(this).siblings().removeClass('addressActive');
        $(this).addClass('addressActive');
    });
    $('.addressSave').click(function () {
        var obj = {};
        obj['status'] = check;
        $(".sendFormaddress").find('select').each(function () {
            if(!$(this).val()) {
                layer.msg('请选择地址信息');return false;
            }
            obj[$(this).data('name')] = $(this).val();
        });
        if(!$('.layui-layer-msg').length) {
            $.each($('#sendForm').serializeArray(), function (k, val) {
                if(val['value'] == "") {
                    layer.msg('必填项不可为空');return false;
                }
                if(val['name'] == 'number') {
                    if(!isPhoneNo(val['value'])) {
                        layer.msg('请填写正确的手机号'); return false;
                    }
                }
                obj[val['name']] = val['value'];
            });
        }
        if(!$('.layui-layer-msg').length) {
            obj['type'] = 'receiveForm';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{{ route("personal.createaddress") }}",
                data:obj,
                success:function (res) {
                    if(res.status == 200) {
                        layer.msg(res.info);
                        setTimeout(function () {
                            window.location.reload();
                        }, 300)
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    //返回提示信息
                    try {
                        if(XMLHttpRequest.status == 401) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        var errors = JSON.parse(XMLHttpRequest.responseText)['errors'];
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    }
                }
            });
        }
    });
    $('input[name=status]').change(function () {
        if($(this).is(':checked')) {
            check = true;
        } else {
            check = false;
        }
    });
</script>
@endsection
