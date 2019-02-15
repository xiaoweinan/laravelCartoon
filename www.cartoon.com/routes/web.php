<?php
Route::get('/',function(){
	return view('welcome');
});
//后台路由分组
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['CheckLogin']],function(){
	Route::get('index','IndexController@index');
	Route::get('welcome','IndexController@welcome');
	//角色管理
	Route::get('adminrole','AdminController@adminrole');
	//添加角色
	Route::match(['get','post'],'roleadd','AdminController@roleadd');
	//验证角色名称
	Route::get('checkrolename','AdminController@checkrolename');
	//编辑角色
	Route::get('roleedit','AdminController@roleedit');
	//管理员列表
	Route::get('adminlist','AdminController@adminlist');	
	//添加管理员
	Route::match(['get','post'],'adminadd','AdminController@adminadd');
	Route::get("checkname","AdminController@checkname");
	//编辑管理员
	Route::match(['get','post'],'adminedit','AdminController@adminedit');
	//权限管理
	Route::get('permission','AdminController@permission');
	//添加权限
	Route::match(['get','post'],'permissionadd','AdminController@permissionadd');
});
//后台登录
	Route::match(['get','post'],'/admin/login','Admin\LoginController@login');
	//验证码
	Route::get('/admin/captcha','Admin\LoginController@captcha');
	//退出登录
	Route::get('/admin/logout','Admin\LoginController@logout');








