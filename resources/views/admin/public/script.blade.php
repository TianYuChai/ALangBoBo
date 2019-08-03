<script type="text/javascript">
    {{--layui.extend({--}}
        {{--admin: "{/}{{ asset('admin/static/js/admin') }}"--}}
    {{--});--}}
    layui.use(['jquery', 'element','util', 'admin', 'carousel'], function() {
        var element = layui.element,
            $ = layui.jquery,
            carousel = layui.carousel,
            util = layui.util,
            admin = layui.admin;
        //建造实例
        carousel.render({
            elem: '.weadmin-shortcut'
            ,width: '100%' //设置容器宽度
            ,arrow: 'none' //始终显示箭头
            ,trigger: 'hover'
            ,autoplay:false
        });

        carousel.render({
            elem: '.weadmin-notice'
            ,width: '100%' //设置容器宽度
            ,arrow: 'none' //始终显示箭头
            ,trigger: 'hover'
            ,autoplay:true
        });

        $(function(){
            setTimeAgo(2018,0,1,13,14,0,'#firstTime');
            setTimeAgo(2018,2,28,16,0,0,'#lastTime');
        });
        function setTimeAgo(y, M, d, H, m, s,id){
            var str = util.timeAgo(new Date(y, M||0, d||1, H||0, m||0, s||0));
            $(id).html(str);
        };
        $('.edit_pass').click(function () {
            layer.prompt({title: '请输入新的登陆密码!', formType: 1}, function(text, index){
                layer.close(index);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method:"post",
                    url:"{!! route('backstage.login.editpass') !!}",
                    data:{'edit_pass': text},
                    success:function (res) {
                        if(res.status == 200) {
                            layer.msg(res.info);
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000)
                        }
                    },
                    error:function (XMLHttpRequest) {
                        //返回提示信息
                        var errors = XMLHttpRequest.responseJSON.errors;
                        for (var value in errors) {
                            layer.msg(errors[value][0]);return;
                        }
                    }
                });
            });
        });
    });
</script>
