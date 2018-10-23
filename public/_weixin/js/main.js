/**
 * 站点程序入口文件（采用requireJs规范）
 * 
 */
requirejs.config({
	baseUrl: '/_weixin/js',

	//已baseUrl为基础定义不同js文件的路径
	//文件路径不可包含后缀名 js
	paths: {
		jquery: 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min',
		'jquery-weui': 'https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min',
		fastclick: 'https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min',
		
		//modules
		myPage: 'modules/myPage',
//		mySearch: 'modules/mySearch',
		myForm: 'modules/myForm',
		myValidator: 'modules/myValidator',
		myResult: 'modules/myResult',
		mySelectArticleCate: 'modules/mySelectArticleCate',
		myTable: 'modules/myTable',
		myDropzone: 'modules/myDropzone',
		myCheckbox: 'modules/myCheckbox',
		myGaodemap: 'modules/myGaodemap',
		
		//pages
		LoginPage : 'pages/Auth/LoginPage',
		AuthChangePasswordPage : 'pages/Auth/AuthChangePasswordPage',
	},

	//定义不同js的依赖关系
	//当然可以在define中进行定义，但是对于第三方库需要另一个第三方库的时候
	//在shim中定义是最简单的
	shim: {
		"jquery-weui": ["jquery"],
	}
});

// Start the main app 
requirejs(
	['jquery', 
	'fastclick', 
	'jquery-weui', 
	'myPage',
	'myForm'
	],
	function($, FastClick) {
		FastClick.attach(document.body);
//		requirejs(['myForm'], function(myNavbar) {})
	});