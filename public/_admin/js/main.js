/**
 * 站点程序入口文件（采用requireJs规范）
 * 
 */
requirejs.config({
	baseUrl: '/_admin/js',

	//已baseUrl为基础定义不同js文件的路径
	//文件路径不可包含后缀名 js
	paths: {
		jquery: 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min',
//		fastclick: 'https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min',
		bootstrap: 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min',
		bootstrapvalidator: 'https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min',
		bootstrapvalidator_language: 'https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/zh_CN.min',
		nprogress: 'https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min',
//		pnotify: 'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify',
		//mouse0270-bootstrap-notify
		bootstrap_notify: 'https://cdn.bootcss.com/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min',
		GaodeMap : 'https://webapi.amap.com/maps?v=1.4.10&key=bf7d1e214598b146869b101434b3210a',
		GaodeMapUi : 'https://webapi.amap.com/ui/1.0/main.js?v=1.0.11',
		datetimepicker : 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min',
		daterangepicker : 'https://cdn.bootcss.com/bootstrap-daterangepicker/3.0.3/daterangepicker.min',
		datetimepicker_moment : 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment-with-locales.min',
		moment : 'https://cdn.bootcss.com/bootstrap-daterangepicker/3.0.3/moment.min',
		select2 : 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.1/js/select2.min',
		select2_zh_cn : 'https://cdn.bootcss.com/select2/4.0.6-rc.1/js/i18n/zh-CN',
		
		myFramework: 'modules/myFramework',
		myValidator: 'modules/myValidator',
		myResult: 'modules/myResult',
//		myPnotify: 'modules/myPnotify',
		myGaodemap: 'modules/myGaodemap',
		
		//pages
		//index
		WorkyardAdminHomePage : 'pages/Index/WorkyardAdminHomePage',
		WorkyardSuperAdminHomePage : 'pages/Index/WorkyardSuperAdminHomePage',
		
		//Auth
		LoginPage : 'pages/Auth/LoginPage',
		AuthChangePasswordPage : 'pages/Auth/AuthChangePasswordPage',
		
		//account
		AccountChangePasswordPage : 'pages/Account/AccountChangePasswordPage',
		
		//Users
		UserListPage : 'pages/User/UserListPage',
		UserAddModal : 'pages/User/UserAddModal',
		UserEditModal : 'pages/User/UserEditModal',
		UserResetPasswordModal : 'pages/User/UserResetPasswordModal',
		
		//Guard
		GuardAddModal : 'pages/Guard/GuardAddModal',
		GuardEditModal : 'pages/Guard/GuardEditModal',
		
		//Point
		PointListPage : 'pages/Point/PointListPage',
		PointAddPage : 'pages/Point/PointAddPage',
		PointEditPage : 'pages/Point/PointEditPage',
		
		//ShiftType
		ShiftTypeListPage : 'pages/ShiftType/ShiftTypeListPage',
		ShiftTypeAddModal : 'pages/ShiftType/ShiftTypeAddModal',
		ShiftTypeEditModal : 'pages/ShiftType/ShiftTypeEditModal',
		ShiftTypeDeleteModal : 'pages/ShiftType/ShiftTypeDeleteModal',
		
		//Shift
		ShiftListPage : 'pages/Shift/ShiftListPage',
		ShiftDetailModal : 'pages/Shift/ShiftDetailModal',
		ShiftAddModal : 'pages/Shift/ShiftAddModal',
		ShiftEditModal : 'pages/Shift/ShiftEditModal',
		ShiftDeleteModal : 'pages/Shift/ShiftDeleteModal',
		ShiftHistoryListPage : 'pages/Shift/ShiftHistoryListPage',
		
		//ShiftGuard
		ShiftGuardListPage : 'pages/ShiftGuard/ShiftGuardListPage',
		ShiftGuardDetailModal : 'pages/ShiftGuard/ShiftGuardDetailModal',
		
		//WebsiteSettingPage
		WebsiteBasicPage:'pages/Website/WebsiteBasicPage',
		WebsiteEmailPage:'pages/Website/WebsiteEmailPage',
		
		//WebsiteSettingPage
		WorkyardListPage:'pages/Workyard/WorkyardListPage',
		WorkyardAddPage:'pages/Workyard/WorkyardAddPage',
		WorkyardEditPage:'pages/Workyard/WorkyardEditPage',
	},

	//定义不同js的依赖关系
	//当然可以在define中进行定义，但是对于第三方库需要另一个第三方库的时候
	//在shim中定义是最简单的
	shim: {
		"bootstrap": ["jquery"],
		"bootstrapvalidator": ["bootstrap"],
		"select2": ["bootstrap"],
		"bootstrap_notify": ["bootstrap"],
		"bootstrapvalidator_language": ["bootstrapvalidator"],
		"datetimepicker": ['datetimepicker_moment'],
//		"daterangepicker": ['moment'],
	}
});

// Start the main app 
requirejs(
	['myFramework'],
	function($) {
		//预加载一些
		requirejs(['bootstrap_notify', 'myValidator', 'myResult'], function() {})
	});