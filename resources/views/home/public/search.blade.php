<div class="container searchPart">
    <div class="relative">
        <img src="{{ asset('home/images/img/logo.png') }}" alt="" class="logoImg"/>
    </div>
    <div class="searchForm">
        <form action="{{ url('product', ['type' =>'opther-all']) }}" method="get">
            <fieldset class="fieldset">
                <div class="searchDiv">
                    <input type="text" placeholder="" name="keyword" value="{{ Input::get('keyword') }}"/>
                    <button type="submit" class="searchBtn">搜索</button>
                </div>
            </fieldset>
        </form>
        <div class="hotSearch">
            <ul class="hotSearchList clearfix">
                <li>
                    <a href=""  class="active mgl-10">水饺</a>
                </li>
            </ul>
        </div>
    </div>
</div>
