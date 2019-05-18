@extends('home.public.subject')
@section('title', '阿朗博波-个人商务中心')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('home/common/bootstrap.min.css') }}"><!--可无视-->
    <link rel="stylesheet" href="{{ asset('home/common/citySelect.css') }}">
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/merchantCenter_shInfo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/cityLayout.css') }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/distpicker/2.0.3/distpicker.js"></script>
@endsection
@section('content')
    {{--搜索--}}
    @include('home.public.search')
    {{--分类导航--}}
    @include('home.public.category')
    <!--内容区-->
    <div class="container clearfix">
        <!--左边菜单栏-->
        <div class="fl mgt-30">
            <ul class="shLeftNav">
                <li class="firstLevel">
                    <p>{{ Auth::guard('web')->user()->category !=0 ? "商户":"个人" }}中心</p>
                    <ul>
                        @include('home.personal.head_portrait')
                        <li>
                            <a href="{{ route('personal.merchant_data') }}" class="leftNavActive">用户资料</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.index') }}">帐户中心</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.address') }}">地址管理</a>
                        </li>
                        <li>
                            <a href="../html/shopCarList-sum.html">我的购物车</a>
                        </li>
                        <li>
                            <a href="../html/merchantCenter_buyThings.html">已买到的宝贝</a>
                        </li>
                        <li>
                            <a href="{{ route('personal.creditmargin') }}">信用保证金</a>
                        </li>
                        @include('home.personal.judge_merchange')
                        <li>
                            <a href="{{ route('personal.cancellationuser') }}">注销帐户</a>
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
                {{--此处需要判断当前用户为个人还是商户 ，如为个人则显示  个人资料  ，--}}
                {{--如为商户则显示  商户资料   -&#45;&#45;即  个人资料 与 商户资料 同调此页面--}}
                <p>{{ auth()->guard('web')->user()->category == 0 ? "个人资料" : "商户资料" }}</p>
            </div>
            <div class="shInfoDiv shInfoDivIE">
                <p class="shInfoTip">亲爱的{{ auth()->guard('web')->user()->account }}用户，填写真实的资料，有助于好友找到你哦。</p>
                <form class="cmxform" id="shInfoForm">
                    <fieldset>
                        <div class="tl relative">
                            当前头像：
                            <img src="{{ !empty(auth()->guard('web')->user()->headimg) ?
                            FileUpload::url('image', auth()->guard('web')->user()->headimg)
                            : asset('home/images/img/shPerson.png.png') }}" alt="" class="shPerson" style="width: 87px;height: 87px;"/>
                            <div class="shangchuan" style="display:none">
                                <form name="form0" id="form0">
                                    <input type="file" name="file0" id="file0" accept="image/*"/>
                                    <p class="shangchuanType">仅支持jpg、gif、png、jpeg图片文件，且文件小于5M</p>
                                    <input type="hidden" name="head">
                                    <img src="" id="img0" style="width: 300px;height: 200px;">
                                    <button type="submit" class="shangchuanSave" onclick="return false;">保存</button>
                                </form>
                            </div>
                        </div>
                        <div class="nichengDiv">
                            昵称：
                            <input type="text" class="nicheng" value="{{ auth()->guard('web')->user()->account }}" readonly>
                            <p class="nichengDivRemark">*昵称须知：与阿郎博波业务或者卖家品牌冲突的昵称，阿郎博波有权收回</p>
                        </div>
                        <div class="realNameDiv">
                            真实姓名：
                            <input type="text" class="realName" value="{{ auth()->guard('web')->user()->name }}" readonly>
                        </div>
                        <div class="sexDiv">
                            <span class="star">*</span> 性别：
                            <div class="sexRadio">
                                <input id="man"
                                       type="radio"
                                       name="sex"
                                       class="inline-block mgr-10"
                                       {{ auth()->guard('web')->user()->sex == 0 ? "checked" : "" }}
                                       value="0"
                                />男<span class="mgr-30"></span>
                                <input id="woman" type="radio"  name="sex"
                                       class="inline-block" value="1"
                                    {{ auth()->guard('web')->user()->sex == 1 ? "checked" : "" }}
                                />女
                            </div>
                        </div>
                        <div class="birthDiv clearfix">
                            生日：
                            <form name="reg_testdate" id="ymd">
                                <select name="YYYY" onChange="YYYYDD(this.value)">
                                    <option value="">年</option>
                                </select>
                                <select name="MM" onChange="MMDD(this.value)">
                                    <option value="">月</option>
                                </select>
                                <select name="DD">
                                    <option value="">日</option>
                                </select>
                            </form>
                        </div>
                        <div class="liveDiv">
                            居住地：
                            <div data-toggle="distpicker" class="distpicker inline-block" id="distpicker">
                                <?php $live = auth()->guard('web')->user()->live ?  explode('/', auth()->guard('web')->user()->live) : ""?>
                                <div class="inline-block">
                                    <select  data-name="live_eprovince" data-province="{{ $live ? $live[0] : "---- 选择省份 ----" }}" class="outline"></select>
                                </div>
                                <div class="inline-block">
                                    <select data-name="live_city" data-city="{{ $live ? $live[1] : "---- 选择市/区 ----" }}" class="outline"></select>
                                </div>
                                <div class="inline-block">
                                    <select data-name="live_district" data-district="{{ $live ? $live[2] : "---- 选择县/市/区 ----" }}" class="outline"></select>
                                </div>
                            </div>
                        </div>
                        <div class="hometownDiv">
                            家乡：
                            <div data-toggle="distpicker" class="distpicker inline-block">
                                <?php $home = auth()->guard('web')->user()->home ?  explode('/', auth()->guard('web')->user()->home) : ""?>
                                <div class="inline-block">
                                    <select data-name="home_eprovince" data-province="{{ $home ? $home[0]: "---- 选择省份 ----" }}" class="outline"></select>
                                </div>
                                <div class="inline-block">
                                    <select data-name="home_city" data-city="{{ $home ? $home[1] : "---- 选择市/区 ----" }}" class="outline"></select>
                                </div>
                                <div class="inline-block">
                                    <select data-name="home_district" data-district="{{ $home ? $home[2] : "---- 选择县/市/区 ----" }}" class="outline"></select>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom"></div>
                        <button class="shInfoSave" type="submit" onclick="return false">保存</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
<script>
    // 上传预览功能
    $("#file0").change(function(){
        var size = this.files[0].size / 1024;
        var type = this.files[0].type;
        var img_type = (type.substr(type.lastIndexOf("/"))).toLowerCase();
        if(img_type!="/jpg" && img_type!="/gif" && img_type!="/png" && img_type!="/jpeg" || size > 5120) {
            $(".shangchuan").fadeOut();
            setTimeout(function () {
                layer.msg('图片类型错误或超出5M, 请重新选择图片');
            }, 300);
            return false;
        }
        var objUrl = getObjectURL(this.files[0]) ;//获取文件信息
        var formData = new FormData();
        formData.append('file', this.files[0]);
        formData.append('image_path', $('input[name="head"]').val());
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method:"POST",
            url:"{!! route("file.upload") !!}",
            processData: false,
            contentType: false,
            data:formData,
            success:function (res) {
                if(res.status == 200) {
                    $('input[name="head"]').val(res.url[0]);
                    $("#img0").attr("src", objUrl);
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
    //点击头像显示上传表单,再次点击上传表单隐藏
    $(".shPerson").on('click',function(){
        if($(".shangchuan").css("display")=="none"){
            $(".shangchuan").fadeIn();
        }else{
            $(".shangchuan").fadeOut();
        }

    });
    $('.shangchuanSave').click(function () {
        var that = $(this);
        var head_img = $('input[name="head"]').val();
        if(!head_img) {
            layer.msg('请先选择图片'); return false;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method:"POST",
            url:"{!! route("personal.pictureUpload") !!}",
            data:{head_img: head_img},
            success:function (res) {
                if(res.status == 200) {
                    $(".shangchuan").fadeOut();
                    window.location.reload();
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
    //出生年月日  ( 此处也可替换成您觉得方便的年月日方法，随意 )
    function YYYYMMDDstart(){
        var datebirth = "{{ auth()->guard('web')->user()->datebirth }}" ? "{{ auth()->guard('web')->user()->datebirth }}" : "";
        if(datebirth) {
            var birth = datebirth.split('/');
        }
        MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        //先给年下拉框赋内容
        var y  = new Date().getFullYear();
        for (var i = (y-30); i < (y+30); i++) //以今年为准，前30年，后30年
            document.reg_testdate.YYYY.options.add(new Option(" "+ i +" 年", i));

        //赋月份的下拉框
        for (var i = 1; i < 13; i++)
            document.reg_testdate.MM.options.add(new Option(" " + i + " 月", i));

        document.reg_testdate.YYYY.value = birth ? birth[0] : y;
        document.reg_testdate.MM.value = birth ? birth[1] : new Date().getMonth() + 1;
        var n = MonHead[new Date().getMonth()];
        if (new Date().getMonth() ==1 && IsPinYear(YYYYvalue)) n++;
        writeDay(n); //赋日期下拉框Author:meizz
        document.reg_testdate.DD.value = birth ? birth[2] : new Date().getDate();
    }
    if(document.attachEvent)
        window.attachEvent("onload", YYYYMMDDstart);
    else
        window.addEventListener('load', YYYYMMDDstart, false);
    function YYYYDD(str) //年发生变化时日期发生变化(主要是判断闰平年)
    {
        var MMvalue = document.reg_testdate.MM.options[document.reg_testdate.MM.selectedIndex].value;
        if (MMvalue == ""){ var e = document.reg_testdate.DD; optionsClear(e); return;}
        var n = MonHead[MMvalue - 1];
        if (MMvalue ==2 && IsPinYear(str)) n++;
        writeDay(n)
    }
    function MMDD(str)   //月发生变化时日期联动
    {
        var YYYYvalue = document.reg_testdate.YYYY.options[document.reg_testdate.YYYY.selectedIndex].value;
        if (YYYYvalue == ""){ var e = document.reg_testdate.DD; optionsClear(e); return;}
        var n = MonHead[str - 1];
        if (str ==2 && IsPinYear(YYYYvalue)) n++;
        writeDay(n)
    }
    function writeDay(n)   //据条件写日期的下拉框
    {
        var e = document.reg_testdate.DD; optionsClear(e);
        for (var i=1; i<(n+1); i++)
            e.options.add(new Option(" "+ i + " 日", i));
    }
    function IsPinYear(year)//判断是否闰平年
    {
        return(0 == year%4 && (year%100 !=0 || year%400 == 0));
    }
    function optionsClear(e)
    {
        e.options.length = 1;
    }

    $('.shInfoSave').click(function () {
        var obj = {};
        $(".inline-block").find('select').each(function () {
            obj[$(this).data('name')] = $(this).val();
        });
        $.each($('#shInfoForm').serializeArray(), function (k, val) {
            if(val['name'] == 'sex') {
                obj[val['name']] = val['value'];
            }
        });
        $('#ymd').find('select').each(function () {
            that = $(this);
            obj[that.attr('name')] = that.val();
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method:"POST",
            url:"{!! route("personal.homeLive") !!}",
            data:{home_live: obj},
            success:function (res) {
                if(res.status == 200) {
                    layer.msg(res.info);
                    setTimeout(function () {
                        window.location.reload();
                    }, 300);
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
</script>
@endsection
