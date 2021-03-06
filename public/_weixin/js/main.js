/**
 * 站点程序入口文件（采用requireJs规范）
 * 
 */
requirejs.config({
	baseUrl: '/_weixin/js',

	//已baseUrl为基础定义不同js文件的路径
	//文件路径不可包含后缀名 js
	paths: {
		jquery: 'https://cdn.bootcss.com/jquery/3.3.1/jquery.min',
		'jquery-weui': 'https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min',
		fastclick: 'https://cdn.bootcss.com/fastclick/1.0.6/fastclick.min',
		jweixin: 'http://res.wx.qq.com/open/js/jweixin-1.4.0',
		jquery_validate: 'http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min',

		//modules
		myPage: 'modules/myPage',
		myWeiXinJs: 'modules/myWeiXinJs',
		myForm: 'modules/myForm',
		myResult: 'modules/myResult',
		myScanQrcode: 'modules/myScanQrcode',
		myNavbar: 'modules/myNavbar',
		myValidator: 'modules/myValidator',

		//pages
		//Auth
		LoginPage: 'pages/Auth/LoginPage',
		AuthChangePasswordPage: 'pages/Auth/AuthChangePasswordPage',

		//index
		GuardIndexPage: 'pages/Index/GuardIndexPage',

		//Shift
		ShiftPlanAndDonePage: 'pages/Shift/ShiftPlanAndDonePage',
		ShiftLogPage: 'pages/Shift/ShiftLogPage',

		//ShiftTime
		ShiftTimeSuccessPage: 'pages/ShiftTime/ShiftTimeSuccessPage',

		//Account
		AccountIndexPage: 'pages/Account/AccountIndexPage',
		ChangePasswordPage: 'pages/Account/ChangePasswordPage',
		//workyard
		RegisterPage: 'pages/Workyard/RegisterPage',
	},

	//定义不同js的依赖关系
	//当然可以在define中进行定义，但是对于第三方库需要另一个第三方库的时候
	//在shim中定义是最简单的
	shim: {
		"jquery-weui": ["jquery"],
		"jquery_validate": ["jquery"],
	}
});

// Start the main app 
requirejs(
	['jquery',
		'jquery-weui',
	],
	function($) {
		requirejs(['fastclick'], function(FastClick) {
			FastClick.attach(document.body);
		})
		requirejs(['myNavbar'], function() {})
		requirejs(['myPage'], function() {})
		requirejs(['myForm'], function() {})
		var hei = $('body')[0].clientHeight;
		$('.container').css('height', hei);
	});