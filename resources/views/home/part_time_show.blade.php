@extends('home.public.subject')
@section('title', '兼职详情-'.$item->title)
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('home/css/product.css') }}"/>
<link rel="stylesheet" href="{{ asset('home/css/experience-detail.css') }}"/>
@endsection
@section('content')
<!--搜索部分-->
@include('home.public.search')
<!--分类导航-->
@include('home.public.category')
<!--内容部分-->
<div class="container">
    <div class="clearfix mgt-30">
        <img src="{{ $item->image ? FileUpload::url('image', $item->image): asset('home/images/img/experienceProduct.png') }}" alt="" class="fl experienceProduct"/>
        <div class="fl productInfo">
            <p class="infoTittle">职位描述</p>
            <p class="infoDetail height-200">
                {{ $item->describe }}
            </p>
            @if($item->whetSend)
                <span class="receipt">已投递</span>
            @else
                <a href="JavaScript:void(0)" class="receipt" id="send">投递</a>
            @endif
        </div>
        <div class="fr experienceCodeDiv">
            <div class="experienceCode">
                @if(!empty($item->merchant->qr_code))
                    <img src="{{ FileUpload::url('image', $item->user->merchant->qr_code) }}" alt="商家未上传图片"/>
                @else
                    <span> 用户联系方式: {{ $item->merchant->user->number }} </span>
                @endif
            </div>
            <p class="saoyisao">[联系发布者]</p>
        </div>
    </div>
    <div class="productAttr mgt-50">
        <ul class="productAttrUl">
            <li>
                <p>薪资:</p>
                <ul class="clearfix attrList">
                    <li>
                        <p><span class="inline-block experiencePrice">{{ $item->moneys }}</span>元</p>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="productAttrUl">
            <li class="showStyle">
                <p>工作类型:</p>
                <ul class="clearfix attrList">
                    @foreach($categorys as $category)
                        <li class="{{ $item->category_id == $category->id ? 'showStyleActive' : '' }}">
                            <p>{{ $category->cate_name }}</p>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <ul class="productAttrUl">
            <li class="showStyle ">
                <p>结算工资方式:</p>
                <ul class="clearfix attrList">
                    @foreach($settles as $key => $settle)
                        <li class="{{ $item->settle == $key ? 'showStyleActive' : '' }}">
                            <p>按{{ $settle }}</p>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <ul class="productAttrUl">
            <li class="showStyle ">
                <p>工作时间:</p>
                <ul class="clearfix attrList">
                    <li class="showStyleActive">
                        <p>{{ $item->time }}</p>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!--详情-->
    <div class="textRecord mgt-50">
        <p class="mgb-20">详情</p>
        <!--此为占位，具体内容具体添加-->
        <div class="clearfix mgt-30">
            {!! $item->content !!}
        </div>
    </div>
</div>
@endsection
@section('section')
<script>
   $('#send').click(function () {
       layer.confirm('确认投递？', {btn: ['确定', '取消'], title: "提示"}, function (index) {
           layer.close(index);
           $.ajax({
               headers: {
                   'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },
               method:"get",
               url:"{{ route("partime.send", ['id' => $item->id]) }}",
               data:'',
               success:function (res) {
                  if(res.status == 200) {
                      window.location.reload();
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
   });
</script>
@endsection
