/*
 * @Author: https://github.com/WangEn
 * @Author: https://gitee.com/lovetime/
 * @Date:   2018-03-27
 * @lastModify 2018-3-28
 * +----------------------------------------------------------------------
 * | WeAdmin 表格table中多个删除等操作公用js
 * | 有改用时直接复制到对应页面也不影响使用
 * +----------------------------------------------------------------------
 */
layui.use(['laydate', 'jquery', 'admin'], function() {
	var laydate = layui.laydate,
		$ = layui.jquery,
		admin = layui.admin;
	//执行一个laydate实例
	laydate.render({
		elem: '#start' //指定元素
	});
	//执行一个laydate实例
	laydate.render({
		elem: '#end' //指定元素
	});
});
