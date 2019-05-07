@extends('home.public.subject')
@section('title', '阿朗博波-个人商务中心')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_address.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_accountCenter.css') }}"/>
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
                <li class="firstLevel">
                    <p>商户中心</p>
                    <ul>
                        <li>
                            @include('home.personal.head_portrait')
                        </li>
                        <li>
                            <a href="{{ route('personal.merchant_data') }}">商户资料</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.index') }}">帐户中心</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.address') }}" class="leftNavActive">地址管理</a>
                        </li>
                        <li>
                            <a href="../html/shopCarList-sum.html">我的购物车</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="">信用保证金</a>
                        </li>
                        <li>
                            <a href="">商家入驻费</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_cancelAccount.html">商户注销帐户</a>
                        </li>
                    </ul>
                </li>
                <li class="firstLevel">
                    <p>店铺管理</p>
                    <ul>
                        <li>
                            <a href="../html/shopManage_shopSign.html">店招更换</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_navMenu.html">导航菜单栏</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_bannerList.html">店铺轮播</a>
                        </li>
                        <li>
                            <a href="../html/shopManage_productManage.html">商品管理</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">订单管理</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_accountCenter.html">账务中心</a>
                        </li>
                    </ul>
                </li>
                <li class="firstLevel">
                    <p>分享推广</p>
                    <ul>
                        <li>
                            <a href="">生成链接</a>
                        </li>
                        <li>
                            <a href="">推广统计</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--右边内容区-->
        <div class="fl mgt-30">
            <div class="shInfoTittle">
                <p>地址管理</p>
            </div>
            <div class="shInfoDiv">
                <!--列表部分-->
                <div class="receiveSend">
                    <ul id="myTab" class="nav nav-tabs accountList">
                        <li class="active">
                            <a href="#receiveAddress" data-toggle="tab">
                                收货地址
                            </a>
                        </li>
                        @if(Auth::guard('web')->user()->category != 0)
                            <li>
                                <a href="#sendAddress" data-toggle="tab">发货地址</a>
                            </li>
                        @endif
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <!--tab1 收货地址-->
                        <div class="tab-pane fade in active" id="receiveAddress">
                            <form class="cmxform" id="receiveForm">
                                <fieldset class="fieldset clearfix">
                                    <a class="addLink">新增收货地址</a>
                                    <div class="addressDiv mgt-20">
                                        <span class="receiveStar">*</span>地址信息：
                                        <div data-toggle="distpicker" class="distpicker inline-block">
                                            <div class="inline-block receiveFormaddress">
                                                <select data-name="eprovince" data-province="- 省份 -" class="outline"></select>
                                            </div>
                                            <div class="inline-block receiveFormaddress">
                                                <select data-name="city" data-city="-市/区 -" class="outline"></select>
                                            </div>
                                            <div class="inline-block receiveFormaddress">
                                                <select data-name="district" data-district="- 县/市/区 --" class="outline"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detailInfoDiv mgt-20">
                                        <span class="receiveStar">*</span>详细地址：
                                        <textarea name="detailed"
                                                  cols="30"
                                                  rows="10"
                                                  placeholder="请输入详细地址信息，如道路、门牌号、小区、楼栋号、单元等信息"></textarea>
                                    </div>
                                    <div class="postNumDiv mgt-20">
                                        邮政编码：
                                        <input type="text" class="postNum" id="postNum" name="code" autocomplete="off">
                                    </div>
                                    <div class="receiveNameDiv mgt-20">
                                        <span class="receiveStar">*</span>收货人姓名：
                                        <input type="text"
                                               class="receiveName"
                                               name="contacts" autocomplete="off">
                                    </div>
                                    <div class="receiveNameDiv mgt-20">
                                        <span class="receiveStar">*</span>手机号码：
                                        <input type="text" class="mobile" name="number" autocomplete="off">
                                    </div>
                                    <div class="morenDiv mgt-20">
                                        <input type="checkbox" name="status" value="1"/>设置为默认收货地址
                                    </div>
                                    <button type="submit" class="addressSave" onclick="return false" data-type="receiveForm">保存</button>
                                </fieldset>
                            </form>
                            <!--收货地址列表-->
                            <div class="receiveAddressList">
                                <div class="saveAddressTip">
                                    <img src="{{ asset('home/images/icon/addressIcon.png') }}"/>
                                    <p>已保存 <span>{{ $items['harvests']['harvest_count'] }}</span>条地址，还能保存 <span>{{ 20 - $items['harvests']['harvest_count'] }}</span>条地址</p>
                                </div>
                                <table align="center" class="table tl" frame="box" border="1">
                                    <thead class="thead">
                                    <tr>
                                        <th>收货人</th>
                                        <th>所在地区</th>
                                        <th>详细地址</th>
                                        <th>邮编</th>
                                        <th>电话/手机</th>
                                        <th>操作</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody tl">
                                    @foreach($items['harvests']['harvest'] as $item)
                                        <tr>
                                            <td>{{ $item->contacts }}</td>
                                            <td> {{ $item->address }} </td>
                                            <td> {{ $item->detailed }} </td>
                                            <td> {{ $item->code ?? "未填写" }} </td>
                                            <td> {{ $item->number }} </td>
                                            <td><a href="javascript:void(0);" onclick='deleteTr(this, "{{ route('personal.addressdel', ['id' => $item->id]) }}");' class="deleteBtn">删除</a> </td>
                                            <td>
                                                @if($item->whether_rece_address)
                                                    <p class="morenP">默认地址</p>
                                                @else
                                                    <p>非默认地址</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(Auth::guard('web')->user()->category != 0)
                            <!--tab2 发货地址-->
                            <div class="tab-pane fade in" id="sendAddress">
                                <form class="cmxform" id="sendForm">
                                    <fieldset class="fieldset clearfix">
                                        <a class="addLink">新增收货地址</a>
                                        <div class="postNumDiv mgt-20 linkManDiv">
                                            <span class="receiveStar">*</span> 联系人：
                                            <input type="text" class="linkMan" id="linkMan" name="linkMan" autocomplete="off">
                                        </div>
                                        <div class="addressDiv sendAddressDiv mgt-20">
                                            <span class="receiveStar">*</span>所在地区：
                                            <div data-toggle="distpicker" class="distpicker inline-block">
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
                                        <div class="detailInfoDiv sendDetailDiv mgt-20">
                                            <span class="receiveStar">*</span>街道地址：
                                            <textarea name="detailed" cols="30" rows="10" placeholder="不需要重复填写省/市/区"></textarea>
                                        </div>
                                        <div class="postNumDiv sendPostNumDiv mgt-20">
                                            邮政编码：
                                            <input type="text" class="sendPostNum"  name="code" autocomplete="off">
                                        </div>
                                        <div class="tellNumDiv mgt-20">
                                            电话号码：
                                            <input type="text" class="sendPostNum inline-block" name="tel[]" autocomplete="off">
                                            <span>-</span>
                                            <input type="text" class="sendPostNum inline-block" name="tel[]" autocomplete="off">
                                            <span>-</span>
                                            <input type="text" class="sendPostNum inline-block" name="tel[]" autocomplete="off">
                                            <p class="tellTip">区号-电话-分机号码</p>
                                        </div>
                                        <div class="receiveNameDiv sendMobileDiv  mgt-20">
                                            <span class="receiveStar">*</span>手机号码：
                                            <input type="text" class="sendMobile" name="number" autocomplete="off">
                                        </div>
                                        <div class="postNumDiv companyNameDiv mgt-20">
                                            <span class="receiveStar">*</span> 公司名称：
                                            <input type="text" class="companyName"  name="corname" autocomplete="off">
                                        </div>
                                        <button type="submit" class="addressSave" onclick="return false" data-type="sendAddress">保存设置</button>
                                    </fieldset>
                                </form>
                                <!--receiveAddressList发货地址列表-->
                                <div class="sendAddressList">
                                    <div class="saveAddressTip">
                                        <img src="{{ asset('home/images/icon/addressIcon.png') }}"/>
                                        <p>已保存 <span>{{ $items['shippings']['shipping_count'] }}</span>条地址，还能保存 <span>{{ 20 - $items['shippings']['shipping_count'] }}</span>条地址</p>
                                    </div>
                                    <table align="center" class="table tl" frame="box" border="1">
                                        <thead class="thead">
                                        <tr>
                                            <th>发货地址</th>
                                            <th>退货地址</th>
                                            <th>联系人</th>
                                            <th>所在地区</th>
                                            <th>街道地址</th>
                                            <th>邮政编码</th>
                                            <th>电话号码</th>
                                            <th>手机号码</th>
                                            <th>公司名称</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody tl">
                                        @foreach($items['shippings']['shipping'] as $item)
                                            <tr>
                                                <td>
                                                    <input type="radio" checked/> 默认
                                                </td>
                                                <td> <input type="radio" checked/> 默认 </td>
                                                <td> {{ $item->contacts }} </td>
                                                <td> {{ $item->address }} </td>
                                                <td> {{ $item->detailed }} </td>
                                                <td> {{ $item->code ?? "未填写" }} </td>
                                                <td> {{ $item->tel ?? "未填写" }} </td>
                                                <td> {{ $item->number }} </td>
                                                <td> {{ $item-> }} </td>
                                                <td>
                                                    {{--<a href="javascript:void(0);" class="editBtn">编辑</a>--}}
                                                    <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
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
        $('.addressSave').click(function () {
            var obj = {};
            var that = $(this);
            var type = that.data('type');
            if(type == 'receiveForm') {
                obj['status'] = check;
            }
            $("."+ type + 'address').find('select').each(function () {
                if(!$(this).val()) {
                    layer.msg('请选择地址信息');return false;
                }
                obj[$(this).data('name')] = $(this).val();
            });
            $.each($('#'+ type).serializeArray(), function (k, val) {
                if(val['name'] != 'code' || val['name'] !='tel') {
                    if(val['value'] == "") {
                        layer.msg('必填项不可为空');return false;
                    }
                }
                if(val['name'] == 'number') {
                    if(!isPhoneNo(val['value'])) {
                        layer.msg('请填写正确的手机号'); return false;
                    }
                }
                obj[val['name']] = val['value'];
            });
            if(!$('.layui-layer-msg').length) {
                console.log(obj);
            }
        });
        //删除操作
        function deleteTr(nowTr, url){
            layer.confirm('是否进行该操作？', {
                btn: ['是','否'] //按钮
            },  function(index){
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"GET",
                    url:url,
                    success:function (res) {
                        if(res.status == 200) {
                            layer.msg(res.info);
                            $(nowTr).parent().parent().remove();
                            $(this).closest('tr').remove();  //清空当前行
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
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        }
                    }
                });
            });
        }
        $('input[name=status]').change(function () {
           if($(this).is(':checked')) {
               check = true;
           } else {
               check = false;
           }
        });
        // //全选删除
        // $(".clear").on('click',function(){
        //     $("table tbody tr").remove();
        //     $("table tfoot tr").remove();
        // })
    </script>
@endsection

