@extends('admin.public.layout')
@section('title','添加权限')
@section('body')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">权限名称：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" name="title">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">路由：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  value="" name="route">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">上级菜单：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="parent_id" size="1">
				<option value=0>顶级菜单</option>
				@foreach ($datas as $data)
					<option value={{ $data->mod_id }}>{{ $data->title }}</option>
				@endforeach
			</select>
			</span> 
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">排序：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" name="orderby">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">图标：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" name="icon">
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
<script type="text/javascript">
	$('#form-admin-add').submit(function(){
		var form = $(this).serialize();
		// console.log(form);
		$.ajax({
			data:form,
			url:"{{ url('admin/permissionadd') }}",
			dataType:"json",
			type:'post',
			headers:{
				'X-CSRF-token':'{{ csrf_token() }}'
			},
			success:function(res){
				if(res.code==1){
					layer.msg(res.msg,{icon:1,time:1000},function(){
						var index = parent.layer.getFrameIndex(window.name);
						parent.location.reload();
						parent.layer.close(index);
					})
				}else{
					layer.msg(res.msg,{icon:5,time:1000},function(){
						var index = parent.layer.getFrameIndex(window.name);
						parent.layer.close(index);
					})	
				}
			}
		});
		return false;
	})
</script> 
@endsection