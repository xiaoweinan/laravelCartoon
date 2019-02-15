<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;//引入验证码类
use Gregwar\Captcha\PhraseBuilder;//验证码样式类
use Illuminate\Support\Facades\Session;
use App\Http\Models\AdminModel;
use DB;
class LoginController extends Controller
{
	/**
	 * 登录页面
	 * @return [type] [description]
	 */
    public function login(Request $request)
    {
        if(Session::has('admininfo.admin_id')){
            return redirect('admin/index');
        }
        if($request->isMethod('post')){
            $admin_name = $request->admin_name;
            $password = $request->password;
            $verify = $request->verify;
            // var_dump($admininfo);
            if($verify != Session::get('verify')){
                return response()->json(['code'=>0,'msg'=>'验证码错误']);
            }
            if(empty(trim($admin_name)) || empty(trim($password))){
                return response()->json(['code'=>0,'msg'=>'用户名、密码必须填写']); 
            }
            $admininfo = AdminModel::where('admin_name',$admin_name)
                                ->first();
            if(!$admininfo){
                return response()->json(['code'=>0,'msg'=>'账户不存在']); 
            }
            if($admininfo->is_lock == 0){
                return response()->json(['code'=>0,'msg'=>'账户已被锁定']);
            }
            if($admininfo->password != md5($password)){
                return response()->json(['code'=>0,'msg'=>'密码错误']);
            }
            $data['last_login'] = time();
            $data['login_count'] = DB::raw('login_count+1');
            Session::put('admininfo',$admininfo);
            //更新数据库
            $admin_id = $admininfo->admin_id;
            $role_id = $admininfo->role_id;
            $roleinfo = DB::table('admin_role')
                            ->where('role_id','=',$role_id)
                            ->first();
            Session::put('roleinfo',$roleinfo);
            AdminModel::where('admin_id',$admin_id)
                        ->update($data);
            return response()->json(['code'=>1,'url'=>'index']);

        }
    	return view('admin.login.login');
    }
    /**
     * 获取验证码
     * @return [type] [description]
     */
    public function captcha()
    {
    	$phraseBuilder = new PhraseBuilder(4, '0123456789');
    	$captcha = new CaptchaBuilder(null,$phraseBuilder);
    	//调取build()方法 获取验证码
    	$builder = $captcha->build($width=130);
    	//保存验证码在session中
    	Session::put('verify',$builder->getPhrase());
    	//输出验证码图片
    	return response($builder->output())
    					->header('Content-type','image/jpeg');
    }
    public function logout()
    {
        Session::flush();
        return redirect('admin/login');
    }
}	
