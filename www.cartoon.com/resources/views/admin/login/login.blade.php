
<!DOCTYPE html>
<html>
  <head>
        <meta charset="UTF-8">
        <title>CarToon | 后台登陆</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link href="skin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="skin/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="skin/css/blue.css" rel="stylesheet" type="text/css" />
        <style>#imgVerify{width: 120px;margin: 0 auto; text-align: center;display: block;}</style>
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#">
                    <b>CarToon商城</b>
                </a>
            </div>
            <div class="login-box-body">
                <form id="admin-login">
                    <p class="login-box-msg">管理后台</p>
                    <div class="form-group has-feedback">
                        <input type="text" name="admin_name" id="admin_name" class="form-control" placeholder="账号" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" id="password" placeholder="密码" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input style="width:205px" type="text" name="verify" class="form-control" id="verify" placeholder="验证码" />
                        <img class='img' style="margin-top:-2px" height='34px' src="{{ url('admin/captcha') }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" >立即登陆</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
 
    <script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
    <script type="text/javascript" src="lib/layer/2.4/layer.js"></script> 
    <script type="text/javascript">
        $('.img').click(function(){
                var num = Math.random();
                $(this).prop('src', "{{ url('admin/captcha') }}?num="+num);
            });
        $('#admin-login').submit(function(){
            //获取inout框的输入值;
            var admin_name = $('#admin_name').val();
            var password = $('#password').val();
            var verify = $('#verify').val();
            if(admin_name == ''){
                layer.tips('请填写用户名','#admin_name');
                return false;
            }
            if(password == ''){
                layer.tips('请填写密码','#password');
                return false;
            }
            if(verify == ''){
                layer.tips('请输入验证码','#verify');
                return false;
            }
            $.ajax({
                type:'post',
                url: "{{ url('admin/login') }}",
                data: {
                    admin_name:admin_name,
                    password:password,
                    verify:verify
                },
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                success: function(res){
                    if(res.code == 0){
                        layer.msg(res.msg, {icon:2, time:1000}, function(){
                            $('.img').click();
                        });
                    }else{
                        location.href = res.url;
                    }
                }
            });
            
            return false;
        });
    </script>
</html>