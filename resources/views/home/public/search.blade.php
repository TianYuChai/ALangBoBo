<div class="container searchPart">
    <div class="relative">
        <img src="{{ asset('home/images/img/logo.png') }}" alt="" class="logoImg"/>
    </div>
    <div class="searchForm">
        <form action="{{ url('product', ['type' =>'search-all']) }}" method="get">
            <fieldset class="fieldset">
                <div class="searchDiv">
                    <input type="text" placeholder="全站搜索" name="keyword" value="{{ Input::get('keyword') }}"/>
                    <button type="submit" class="searchBtn">搜索</button>
                </div>
            </fieldset>
        </form>
        <div class="hotSearch">
            <ul class="hotSearchList clearfix">
                <?php $redis = \Illuminate\Support\Facades\Redis::get('keywords') ?>
                @if($redis)
                    @foreach(json_decode($redis, true) as $key => $item)
                        @if($key <= 5)
                            <li>
                                <a href="{{ url('product', ['type' =>'search-all']) }}?keyword={{ $item['name'] }}"
                                   class="active mgl-10">{{ $item['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
