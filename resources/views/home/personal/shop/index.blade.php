@extends('home.public.subject')
@section('title', '阿朗博波-店铺管理-店招更换')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/shopManage_shopSign.css') }}"/>
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
                            <a href="../html/merchantCenter_accountCenter.html">帐户中心</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_address.html">收/发货地址</a>
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
                            <a href="../html/shopManage_shopSign.html" class="leftNavActive">店招更换</a>
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
                <p>商户资料</p>
            </div>
            <div class="shInfoDiv">
                <!--判断当前店铺 为 加盟店，直营店还是网店， 显示对应的添加弹框-->
                <!--加盟店 状态更改  data-target="#changeSign-jm"     -->
                <!--直营店 状态更改  data-target="#changeSign-zy"-->
                <!--网店 状态更改  data-target="#changeSign-net"-->
                <a href="" class="changeSignBtn" data-toggle="modal" data-target="#changeSign-zy">
                    <img src="../images/icon/changeIcon.png" alt=""/>
                    更换标志
                </a>
                <div class="changeSignTable">
                    <table align="center" class="table" frame="box">
                        <thead class="thead">
                        <tr>
                            <th>店铺名称</th>
                            <th>商标</th>
                            <th>地址</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="tbody tc">
                        <tr>
                            <td>小资生活</td>
                            <td>
                                <img src="../images/img/logo.png" alt="" class="shopSign"/>
                            </td>
                            <td>安徽省滁州市南谯区南桥路</td>
                            <td>
                                <a href="javascript:void(0);" onclick='deleteTr(this);' class="mgr-10">删除</a>
                                <a href="">查看</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--加盟店添加内容弹窗   如果是加盟店则显示此部分 id = changeSign-jm  -->
                <div class="modal fade" id="changeSign-jm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-jm" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel-jm">
                                    <p class="changeContentTip"><img src="../images/icon/changeContentIcon.png" alt=""/>更换标志</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent">
                                    <form class="changeSignForm" id="changeSignForm-jm" method="get" action="">
                                        <fieldset class="fieldset clearfix">
                                            <div class="jmNameDiv tr">
                                                店铺名称：
                                                <input type="text" class="jmName" id="jmName" name="jmName" autocomplete="off">
                                            </div>
                                            <div class="jmAddressDiv tr">
                                                地址：
                                                <input type="text" class="jmAddress" id="jmAddress" name="jmAddress" autocomplete="off">
                                            </div>
                                            <div class="relative">
                                                <p class="inline-block mgr-20 mgl-15">加盟商标：</p>
                                                <img src="../images/img/idImg.png" alt="" class="jmImg"/>
                                                <!--<input type="file" class="file jmUpload" id="jm" name="jm">-->
                                                <!--浏览按钮-->
                                                <!--点击浏览按钮，显示上传预览弹框-->
                                                <img src="../images/img/changeSignUpload.png" alt="" class="uploadImg"/>
                                                <!--<input type="file" class="file netUpload" id="net" name="net">-->
                                                <div class="shangchuan" style="display: none;">
                                                    <form name="form0" id="form0">
                                                        <input type="file" name="file0" id="file0" multiple="multiple" />
                                                        <img src="" id="img0" style="width: 110px;height: 100px;">
                                                        <button type="submit" class="shangchuanSave">保存</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary">
                                    确定
                                </button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
                <!--直营店添加内容弹窗   如果是直营店则显示此部分 id = changeSign-zy  -->
                <div class="modal fade" id="changeSign-zy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-zy" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel-zy">
                                    <p class="changeContentTip"><img src="../images/icon/changeContentIcon.png" alt=""/>更换标志</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent">
                                    <form class="changeSignForm" id="changeSignForm-zy" method="get" action="">
                                        <fieldset class="fieldset clearfix">
                                            <div class="zyNameDiv tr">
                                                店铺名称：
                                                <input type="text" class="zyName" id="zyName" name="zyName" autocomplete="off">
                                            </div>
                                            <div class="zyAddressDiv tr">
                                                地址：
                                                <input type="text" class="zyAddress" id="zyAddress" name="zyAddress" autocomplete="off">
                                            </div>
                                            <div class="relative">
                                                <p class="inline-block mgr-20 mgl-15">直营商标：</p>
                                                <img src="../images/img/idImg.png" alt="" class="zyImg"/>
                                                <!--<input type="file" class="file zyUpload" id="zy" name="zy">-->
                                                <!--浏览按钮-->
                                                <!--点击浏览按钮，显示上传预览弹框-->
                                                <img src="../images/img/changeSignUpload.png" alt="" class="uploadImg"/>
                                                <!--<input type="file" class="file netUpload" id="net" name="net">-->
                                                <div class="shangchuan" style="display: none;">
                                                    <form name="form1" id="form1">
                                                        <input type="file" name="file1" id="file1" multiple="multiple" />
                                                        <img src="" id="img1" style="width: 110px;height: 100px;">
                                                        <button type="submit" class="shangchuanSave">保存</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary">
                                    确定
                                </button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
                <!--网店添加内容弹窗   如果是网店则显示此部分 id = changeSign-net  -->
                <div class="modal fade" id="changeSign-net" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-net" aria-hidden="true">
                    <div class="modal-dialog modalWidth">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel-net">
                                    <p class="changeContentTip"><img src="../images/icon/changeContentIcon.png" alt=""/>更换标志</p>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="changeContent">
                                    <form class="changeSignForm" id="changeSignForm-net" method="get" action="">
                                        <fieldset class="fieldset clearfix">
                                            <div class="netNameDiv tr">
                                                店铺名称：
                                                <input type="text" class="netName" id="netName" name="netName" autocomplete="off">
                                            </div>
                                            <div class="netAddressDiv tr">
                                                地址：
                                                <input type="text" class="netAddress" id="netAddress" name="netAddress" autocomplete="off">
                                            </div>
                                            <div class="relative">
                                                <p class="inline-block mgr-20 mgl-15">网店商标：</p>
                                                <img src="../images/img/idImg.png" alt="" class="netImg"/>
                                                <!--浏览按钮-->
                                                <!--点击浏览按钮，显示上传预览弹框-->
                                                <img src="../images/img/changeSignUpload.png" alt="" class="uploadImg"/>
                                                <!--<input type="file" class="file netUpload" id="net" name="net">-->
                                                <div class="shangchuan" style="display: none;">
                                                    <form name="form2" id="form2">
                                                        <input type="file" name="file2" id="file2" multiple="multiple" />
                                                        <img src="" id="img2" style="width: 110px;height: 100px;">
                                                        <button type="submit" class="shangchuanSave">保存</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="button" class="btn btn-primary">
                                    确定
                                </button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
            </div>
        </div>
    </div>
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
    //    加盟商标上传预览功能   此处的上传预览功能 在 IE 浏览器可能存在兼容问题   ，麻烦后台大神您费心，用后端语言解决一下，在下已经功力耗尽 哭
    $("#file0").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;//获取文件信息
        console.log("objUrl = "+objUrl);
        if (objUrl) {
            $("#img0").attr("src", objUrl);
        }
    }) ;
    //    直营商标上传预览功能
    $("#file1").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;//获取文件信息
        console.log("objUrl = "+objUrl);
        if (objUrl) {
            $("#img1").attr("src", objUrl);
        }
    }) ;
    //    网店商标上传预览功能
    $("#file2").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;//获取文件信息
        console.log("objUrl = "+objUrl);
        if (objUrl) {
            $("#img2").attr("src", objUrl);
        }
    }) ;
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL!=undefined) {
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
    //    点击 店铺头像显示上传表单,再次点击上传表单隐藏
    $(".uploadImg").on('click',function(){
        if($(this).siblings('div').css("display")=="none"){
            $(this).siblings('div').fadeIn();
        }else{
            $(this).siblings('div').fadeOut();
        }
    });
</script>
@endsection
