@extends('admin.public.layout')
@section('title','添加管理员')
@section('body')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add" method="post">
	<input type="hidden" name="admin_id" value="{{ $admin->admin_id }}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">管理员：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{ $admin->admin_name }}" placeholder="" id="adminName" name="admin_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">初始密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off" value="" placeholder="密码" id="password" name="password">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">确认密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password2" name="password2">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">性别：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="sex" type="radio" id="sex-1" value=1 @if($admin->sex == 1) checked="checked" @endif>
				<label for="sex-1">男</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-2" name="sex" value=0 @if($admin->sex == 0) checked="checked" @endif>
				<label for="sex-2">女</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">邮箱：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" placeholder="@" name="email" id="email" value="{{ $admin->email }}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> 
			<span class="select-box" style="width:150px;">
			<select class="select" name="role_id" size="1">
				@foreach($roles as $role)
				@if($role->role_id == $admin->role_id)
				<option value="{{ $role->role_id }}" selected>{{ $role->role_name }}</option>
				@else
				<option value="{{ $role->role_id }}" >{{ $role->role_name }}</option>
				@endif
				@endforeach
			</select>
			</span> 
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)">{{ $admin->desc }}</textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('js')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-admin-add").validate({
		rules:{
			admin_name:{
				// required:true,
				minlength:4,
				maxlength:16,
				remote:"{{ url('admin/checkname') }}?admin_id="+{{ $admin->admin_id }}
			},
			password:{
			},
			password2:{
				equalTo: "#password"
			},
			email:{
				email:true,
			},
		},
		messages:{
			password2:{
				equalTo:'两次密码不一致'
			},
			admin_name:{
				remote:"<fornt color=red>该用户名已被注册</font>"
			}
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{ url('admin/adminedit') }}" ,
				headers:{
					'X-CSRF-TOKEN':'{{ csrf_token() }}'
				},
				success: function(data){
					layer.msg(data.msg,{icon:1,time:1000},function(){
						var index = parent.layer.getFrameIndex(window.name);
						parent.location.reload();
						parent.layer.close(index);
					});
				},
			});
		}
	});
});
</script> 
@endsection