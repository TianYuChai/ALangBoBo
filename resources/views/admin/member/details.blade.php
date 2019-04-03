@extends('admin.public.plugins')
@section('content')
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>账户信息</legend>
    </fieldset>
    <table class="layui-table" lay-skin="nob" lay-even="">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>类别</th>
            <th>内容</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>账户</td><td>{{ $item->account }}</td></tr>
        <tr><td>账户类别</td><td>{{ $item->category_name }}</td></tr>
        <tr><td>账户状态</td><td>{{ $item->status_name }}</td></tr>
        </tbody>
    </table>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>基本信息</legend>
    </fieldset>
    <table class="layui-table" lay-skin="nob" lay-even="">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>类别</th>
            <th>内容</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>真实姓名</td><td>{{ $item->name }}</td></tr>
        <tr><td>身份证</td><td>{{ $item->card }}</td></tr>
        <tr><td>手机号码</td><td>{{ $item->number }}</td></tr>
        </tbody>
    </table>
    @if($item->category != 0)
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>{{ $item->category == 1 ? "企业商户信息" : "个人商户信息"}}</legend>
        </fieldset>
        <table class="layui-table" lay-skin="nob" lay-even="">
            <colgroup>
                <col width="150">
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>类别</th>
                <th>内容</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>店铺名称</td><td>{{ $item->merchant->shop_name }}</td></tr>
            <tr><td>统一社会信用代码</td><td>{{ $item->merchant->credit_code }}</td></tr>
            <tr><td>申请时间</td><td>{{ $item->merchant->created_at }}</td></tr>
            <tr>
                <td>身份证正面照</td>
                <td>
                    <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->card_positive) }}')">
                        <img class="layui-circle"
                             src="{{ FileUpload::url("image", $item->merchant->card_positive) }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td>身份证反面照</td>
                <td>
                    <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->card_opposite) }}')">
                        <img class="layui-circle"
                             src="{{ FileUpload::url('image', $item->merchant->card_opposite) }}">
                    </div>
                </td>
            </tr>
            @if($item->category == 1)
            <tr>
                <td>营业执照</td>
                <td>
                    <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->bus_license) }}')">
                        <img class="layui-circle"
                             src="{{ FileUpload::url('image', $item->merchant->bus_license) }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td>食品行业</td>
                <td>
                    @if(!empty($item->merchant->food_industry))
                        <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->bus_license) }}')">
                            <img class="layui-circle"
                                 src="{{ FileUpload::url('image', $item->merchant->bus_license) }}">
                        </div>
                    @else
                        用户未上传
                    @endif
                </td>
            </tr>
            <tr>
                <td>美容美发</td>
                <td>
                    @if(!empty($item->merchant->hairdressing))
                        <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->hairdressing) }}')">
                            <img class="layui-circle"
                                 src="{{ FileUpload::url('image', $item->merchant->hairdressing) }}">
                        </div>
                    @else
                        用户未上传
                    @endif
                </td>
            </tr>
            <tr>
                <td>其他行业</td>
                <td>
                    @if(!empty($item->merchant->other))
                        <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->other) }}')">
                            <img class="layui-circle"
                                 src="{{ FileUpload::url('image', $item->merchant->other) }}">
                        </div>
                    @else
                        用户未上传
                    @endif
                </td>
            </tr>
            @else
                <tr>
                    <td>个人证件或作品</td>
                    <td>
                        <div class="layui-inline" onclick="imgshow(this, '{{ FileUpload::url("image", $item->merchant->personal) }}')">
                            <img class="layui-circle"
                                 src="{{ FileUpload::url('image', $item->merchant->personal) }}">
                        </div>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    @endif
@endsection
@section('script')
    <script type="text/javascript">
        layui.use(['layer', 'jquery'], function() {
            var layer = layui.layer,
                $ = layui.jquery;
            window.imgshow = function (obj, url) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: ['920px', '650px'],
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: '<img src="'+url+'">'
                });
            }
        })
    </script>
@endsection
