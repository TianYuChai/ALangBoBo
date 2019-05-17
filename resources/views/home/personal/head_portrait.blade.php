<li>
    <img src="{{ !empty(auth()->guard('web')->user()->headimg) ?
                            FileUpload::url('image', auth()->guard('web')->user()->headimg)
                            : asset('home/images/img/shPerson.png.png') }}" alt="" style="width: 83px;height: 83px;"/>
</li>