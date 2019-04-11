<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{ asset('admin/lib/layui/layui.js') }}" charset="utf-8"></script>
<script type="text/javascript" src="{{ asset('admin/static/js/eleDel.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    layui.extend({
        admin: "{/}{{ asset('admin/static/js/admin') }}"
    });
</script>
<!--/_footer /作为公共模版分离出去-->

