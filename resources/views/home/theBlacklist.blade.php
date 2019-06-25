@extends('home.public.subject')
@section('title', '黑名单公示')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('home/css/blackList-public.css') }}"/>
    <link href="{{ asset('home/common/pagination.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!--搜索部分-->
    @include('home.public.search')
    <!--分类导航-->
    @include('home.public.category')
    <div class="container">
        <div class="blacklistTop">
            <span class="borderLeft"></span>
            <p class="blacklistTip">黑名单公示</p>
        </div>
        <div>
            <ul id="myTab" class="nav nav-tabs shopCarList">
                <li class="active">
                    <a href="#blackList-sj" data-toggle="tab">
                        商家黑名单
                    </a>
                </li>
                <li class="borderRight"></li>
                <li class="">
                    <a href="#blackList-mj" data-toggle="tab">买家黑名单</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content relative">
                <!--tab1 商家黑名单-->
                <div class="tab-pane fade in active" id="blackList-sj">
                    <!--黑名单内容不限-->
                    <a href="" class="publishList-sj" data-toggle="modal" data-target="#publishList-sj">发布黑名单</a>
                    <ul class="blackListUl-sj clearfix">
                       @foreach($data['merchants'] as $item)
                            <li>
                                <p>店铺名称：<span>{{ $item->user->merchant['shop_name'] }}</span></p>
                                <p>黑名单原因 ：<span>{{ $item['why'] }}</span></p>
                                <p>处理结果 ：<span>{{ $item['result'] }}</span></p>
                                <p>禁止营业时间：<span>{{ $item['end_time'] }}</span></p>
                            </li>
                       @endforeach
                    </ul>
                </div>
                <!--tab2 买家黑名单-->
                <div class="tab-pane fade in" id="blackList-mj">
                    <!--黑名单内容不限-->
                    <a href="" class="publishList-mj" data-toggle="modal" data-target="#publishList-mj">发布黑名单</a>
                    <ul class="blackListUl-mj clearfix">
                        @foreach($data['users'] as $value)
                            <li>
                                <p>{{ $value->user['name'] }}：<span>{{ $value->user['number'] }}</span></p>
                                <p>身份证号码：<span>{{ $value->user['card'] }}</span></p>
                                <p>黑名单原因 ：<span>{{ $value->why }}</span></p>
                                <p>处理结果 ：<span>{{ $value->result }}</span></p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--商家黑名单 发布黑名单弹框-->
            <div class="modal fade" id="publishList-sj" tabindex="-1" role="dialog" aria-labelledby="publishList-sj" aria-hidden="true">
                <div class="modal-dialog modalWidth">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">
                                <p class="changeContentTip">发布黑名单</p>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="changeContent">
                                <form class="blackList-qy" id="blackList-qy">
                                    <fieldset class="fieldset clearfix">
                                        <!--企业商家黑名单 发布-->
                                        <div class="mgr-50">
                                            <div class="comNameDiv tr">
                                                公司名称 ：
                                                <input type="text" class="comName"
                                                       id="comName"
                                                       name="comName" autocomplete="off">
                                            </div>
                                            <div class="reasonDiv mgt-20 tr">
                                                黑名单原因：
                                                <textarea name="" cols="30" rows="10" id="shop_why"></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                            </button>
                            <button type="button" class="btn btn-primary merchan_add">
                                提交
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
            <!--买家黑名单 发布黑名单弹框-->
            <div class="modal fade" id="publishList-mj" tabindex="-1" role="dialog" aria-labelledby="publishList-mj" aria-hidden="true">
                <div class="modal-dialog modalWidth">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">
                                <p class="changeContentTip">发布黑名单</p>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="changeContent">
                                <form class="blackList-mj" method="get" action="">
                                    <fieldset class="fieldset clearfix">
                                        <!--企业商家黑名单 发布-->
                                        <div class="mgr-50">
                                            <p class="publicTip mgl-30">买家黑名单 </p>
                                            <div class="mjNameDiv tr">
                                                账号：
                                                <input type="text" class="mjName"
                                                       id="mjName"
                                                       name="mjName" autocomplete="off">
                                            </div>
                                            <div class="mjReasonDiv mgt-20 tr">
                                                黑名单原因：
                                                <textarea name="" id="user_why" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                            </button>
                            <button type="button" class="btn btn-primary user_add">
                                提交
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>
@endsection
@section('shop')
@endsection
@section('section')
    <script type="text/javascript">
        $('.merchan_add').click(function () {
            let name = $("#comName").val();
            let why = $('#shop_why').val();
            if(!name) {
                layer.msg('请先输入商家店铺名称');return false;
            }
            if(!why) {
                layer.msg('请输入提交原因');return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.theBlacklist.merchantStore') !!}",
                data:{name: name, why: why},
                success:function (res) {
                    if(res.status == 200) {
                        layer.msg(res.info);
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    $(".merchan_add").attr('disabled','disabled');
                    try {
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(JSON.parse(XMLHttpRequest.responseText)['errors']) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        } else {
                            layer.msg(JSON.parse(XMLHttpRequest.responseText)['message'] == 'Unauthenticated.' ?
                                '请先请往登陆' : JSON.parse(XMLHttpRequest.responseText)['message']);return;
                        }
                    }
                }
            });
        });
        /*监听用户输入商家是否存在*/
        $('#comName').change(function () {
            let val = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.theBlacklist.select') !!}",
                data:{name: val},
                success:function (res) {
                    if(res.status == 200) {
                        $(".merchan_add").removeAttr('disabled');
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    $(".merchan_add").attr('disabled','disabled');
                    try {
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(JSON.parse(XMLHttpRequest.responseText)['errors']) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        } else {
                            layer.msg(JSON.parse(XMLHttpRequest.responseText)['message'] == 'Unauthenticated.' ?
                                '请先请往登陆' : JSON.parse(XMLHttpRequest.responseText)['message']);return;
                        }
                    }
                }
            });
        });
        $('.user_add').click(function () {
            let name = $('.mjName').val();
            let why = $('#user_why').val();
            if(!name) {
                layer.msg('请输入要举报账号');return false;
            }
            if(!why) {
                layer.msg('请填写举报原因');return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.theBlacklist.userStore') !!}",
                data:{name: name, why: why},
                success:function (res) {
                    if(res.status == 200) {
                        layer.msg(res.info);
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    $(".merchan_add").attr('disabled','disabled');
                    try {
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(JSON.parse(XMLHttpRequest.responseText)['errors']) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        } else {
                            layer.msg(JSON.parse(XMLHttpRequest.responseText)['message'] == 'Unauthenticated.' ?
                                '请先请往登陆' : JSON.parse(XMLHttpRequest.responseText)['message']);return;
                        }
                    }
                }
            });
        });
        /*监听输入用户是否本站用户*/
        $('.mjName').change(function () {
            let val = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method:"POST",
                url:"{!! route('index.theBlacklist.selectuser') !!}",
                data:{name: val},
                success:function (res) {
                    if(res.status == 200) {
                        $(".user_add").removeAttr('disabled');
                    }
                },
                error:function (XMLHttpRequest) {
                    //返回提示信息
                    $(".user_add").attr('disabled','disabled');
                    try {
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    } catch (e) {
                        if(JSON.parse(XMLHttpRequest.responseText)['errors']) {
                            var errors = JSON.parse(XMLHttpRequest.responseText)['errors']['info'];
                            layer.msg(errors[0]);return;
                        } else {
                            layer.msg(JSON.parse(XMLHttpRequest.responseText)['message'] == 'Unauthenticated.' ?
                                '请先请往登陆' : JSON.parse(XMLHttpRequest.responseText)['message']);return;
                        }
                    }
                }
            });
        });
    </script>
@endsection
