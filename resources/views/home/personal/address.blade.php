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
                            <form class="cmxform" id="receiveForm" method="get" action="">
                                <fieldset class="fieldset clearfix">
                                    <a class="addLink">新增收货地址</a>
                                    <div class="addressDiv mgt-20">
                                        <span class="receiveStar">*</span>地址信息：
                                        <div data-toggle="distpicker" class="distpicker inline-block">
                                            <div class="inline-block">
                                                <select data-province="- 省份 -" class="outline"></select>
                                            </div>
                                            <div class="inline-block">
                                                <select data-city="-市/区 -" class="outline"></select>
                                            </div>
                                            <div class="inline-block">
                                                <select data-district="- 县/市/区 --" class="outline"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detailInfoDiv mgt-20">
                                        <span class="receiveStar">*</span>详细地址：
                                        <textarea name="" cols="30" rows="10" placeholder="请输入详细地址信息，如道路、门牌号、小区、楼栋号、单元等信息"></textarea>
                                    </div>
                                    <div class="postNumDiv mgt-20">
                                        邮政编码：
                                        <input type="text" class="postNum" id="postNum" name="postNum" autocomplete="off">
                                    </div>
                                    <div class="receiveNameDiv mgt-20">
                                        <span class="receiveStar">*</span>收货人姓名：
                                        <input type="text" class="receiveName" id="receiveName" name="receiveName" autocomplete="off">
                                    </div>
                                    <div class="receiveNameDiv mgt-20">
                                        <span class="receiveStar">*</span>手机号码：
                                        <input type="text" class="mobile" id="mobile" name="mobile" autocomplete="off">
                                    </div>
                                    <div class="morenDiv mgt-20">
                                        <input type="checkbox"/>设置为默认收货地址
                                    </div>
                                    <button type="submit" class="addressSave">保存</button>
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
                                            <td>默默</td>
                                            <td> 安徽省滁州市 </td>
                                            <td> 南谯区凤凰街道123号 </td>
                                            <td> 239060 </td>
                                            <td> 15623563256 </td>
                                            <td><a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                            <td><p class="morenP">默认地址</p></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(Auth::guard('web')->user()->category != 0)
                            <!--tab2 发货地址-->
                            <div class="tab-pane fade in" id="sendAddress">
                                <form class="cmxform" id="sendForm" method="get" action="">
                                    <fieldset class="fieldset clearfix">
                                        <a class="addLink">新增收货地址</a>
                                        <div class="postNumDiv mgt-20 linkManDiv">
                                            <span class="receiveStar">*</span> 联系人：
                                            <input type="text" class="linkMan" id="linkMan" name="linkMan" autocomplete="off">
                                        </div>
                                        <div class="addressDiv sendAddressDiv mgt-20">
                                            <span class="receiveStar">*</span>所在地区：
                                            <div data-toggle="distpicker" class="distpicker inline-block">
                                                <div class="inline-block">
                                                    <select data-province="- 省份 -" class="outline"></select>
                                                </div>
                                                <div class="inline-block">
                                                    <select data-city="-市/区 -" class="outline"></select>
                                                </div>
                                                <div class="inline-block">
                                                    <select data-district="- 县/市/区 --" class="outline"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="detailInfoDiv sendDetailDiv mgt-20">
                                            <span class="receiveStar">*</span>街道地址：
                                            <textarea name="" cols="30" rows="10" placeholder="不需要重复填写省/市/区"></textarea>
                                        </div>
                                        <div class="postNumDiv sendPostNumDiv mgt-20">
                                            邮政编码：
                                            <input type="text" class="sendPostNum" id="sendPostNum" name="sendPostNum" autocomplete="off">
                                        </div>
                                        <div class="tellNumDiv mgt-20">
                                            电话号码：
                                            <input type="text" class="sendPostNum inline-block" name="tellNum" autocomplete="off">
                                            <span>-</span>
                                            <input type="text" class="sendPostNum inline-block" name="tellNum" autocomplete="off">
                                            <span>-</span>
                                            <input type="text" class="sendPostNum inline-block" name="tellNum" autocomplete="off">
                                            <p class="tellTip">区号-电话-分机号码</p>
                                        </div>
                                        <div class="receiveNameDiv sendMobileDiv  mgt-20">
                                            <span class="receiveStar">*</span>手机号码：
                                            <input type="text" class="sendMobile" id="sendMobile" name="sendMobile" autocomplete="off">
                                        </div>
                                        <div class="postNumDiv companyNameDiv mgt-20">
                                            <span class="receiveStar">*</span> 公司名称：
                                            <input type="text" class="companyName" id="companyName" name="companyName" autocomplete="off">
                                        </div>
                                        <div class="detailInfoDiv sendInfoDiv mgt-20">
                                            备注：
                                            <textarea name="" cols="30" rows="10" placeholder="请输入详细地址信息，如道路、门牌号、小区、楼栋号、单元等信息"></textarea>
                                        </div>
                                        <button type="submit" class="addressSave">保存设置</button>
                                    </fieldset>
                                </form>
                                <!--receiveAddressList发货地址列表-->
                                <div class="sendAddressList">
                                    <div class="saveAddressTip">
                                        <img src="{{ asset('home/images/icon/addressIcon.png') }}"/>
                                        <p>已保存 <span>2</span>条地址，还能保存 <span>18</span>条地址</p>
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
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                {{--<a href="javascript:void(0);" class="editBtn">编辑</a>--}}
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio"/> 默认
                                            </td>
                                            <td> <input type="radio"/> 默认 </td>
                                            <td> 邓思杰 </td>
                                            <td> 浙江省杭州市西湖区 </td>
                                            <td> 西湖小区2-23 </td>
                                            <td> 310051 </td>
                                            <td> 0550-3745632 </td>
                                            <td> 15632365236 </td>
                                            <td> 阿郎博波 </td>
                                            <td>
                                                <a href="javascript:void(0);" class="editBtn">编辑</a>
                                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="deleteBtn">删除</a> </td>
                                        </tr>
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
    <script>
        //    删除操作
        function deleteTr(nowTr){
            //多一个parent就代表向前一个标签,
            // 本删除范围为<td><tr>两个标签,即向前两个parent
            //如果多一个parent就会删除整个table
            $(nowTr).parent().parent().remove();
            $(this).closest('tr').remove();  //清空当前行
        }
        //    全选删除
        $(".clear").on('click',function(){
            $("table tbody tr").remove();
            $("table tfoot tr").remove();
        })
    </script>
@endsection

