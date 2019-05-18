@if(!Auth::guard('web')->user()->whermerchant)
    <li>
        <a href="{{ route('personal.merchant') }}">商家入驻</a>
    </li>
@endif
@if(Auth::guard('web')->user()->whermerchant)
    <li>
        <a href="{{ route('personal.businresidfee') }}">商家入驻费</a>
    </li>
@endif