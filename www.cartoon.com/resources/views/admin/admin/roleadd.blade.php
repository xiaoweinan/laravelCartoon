@extends('admin.public.layout')
@section('title','添加角色')
@section('body')
<article class="page-container">
	<form  class="form form-horizontal" id="form-admin-role-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" id="" name="desc">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">角色权限：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@foreach($parents as $key=>$parent)
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value={{$parent->mod_id}} name="power_id[]" id="user-Character-{{$key}}">
							{{ $parent->title }}
						</label>
					</dt>
					<dd>
						<dl class="cl permission-list2">	
							<dd style="margin-left:0px">
								@foreach($sons as $ke=>$son)
								@if($son->parent_id==$parent->mod_id)
								<label class="">
									<input type="checkbox" value={{$son->mod_id}} name="power_id[]" id="user-Character-{{$key}}-{{$ke}}">
									{{$son->title}}
								</label>
								@endif
								@endforeach
							</dd>	
						</dl>
					</dd>
				</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定
				</button>
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
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
	$("#form-admin-role-add").validate({
		rules:{
			role_name:{
				required:true,
				remote:"{{ url('admin/checkrolename') }}"
			},
		},
		messages:{
			role_name:{
				remote:'该角色已存在'
			}
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				dataType:'json',
				url:"{{ url('admin/roleadd') }}",
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
		}
	});
});
</script>
@endsection
