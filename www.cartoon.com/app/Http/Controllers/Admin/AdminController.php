<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Models\AdminModel;
use Illuminate\Support\Facades\Session;
use App\Http\Models\Permission;
class AdminController extends Controller
{
    /**
     * 管理员列表
     * @return [type] [description]
     */
	public function adminlist()
    {
        $datas = AdminModel::join('admin_role','admin_role.role_id','=','admin.role_id')
                            ->paginate(5);
        return view('admin.admin.adminlist',['datas'=>$datas]);
    }
     /**
     * 检测用户名是否被注册
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkname(Request $request)
    {
        $admin_name = $request->admin_name;
        $admin_id = $request->admin_id;
        if(empty($admin_id)){
            $data = AdminModel::where('admin_name','=',$admin_name)
                            ->count();
            if($data){
                return "false";
            }else{
                return "true";
            }
        }
        if($admin_id){
            $res = AdminModel::where('admin_name',$admin_name)
                            ->where('admin_id','<>',$admin_id)
                            ->count();
            if($res){
                return "false";
            }else{
                return "true";
            }
        }
    }
    /**
     * 添加管理员
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function adminadd(Request $request)
    {
        if($request->isMethod('post')){
           $datas = $request->except(['_token','password2']);
           $datas['password'] = md5($datas['password']);
           $datas['add_time'] = time();
           $res = AdminModel::create($datas);
            if($res){
                return response()->json(['code'=>1,'msg'=>'添加成功']);
            }else{
                return response()->json(['code'=>0,'msg'=>'添加失败']);
            }
        }
        $roles = DB::table('admin_role')
                        ->where('role_name','<>','超级管理员')
                        ->get();
        return view('admin.admin.adminadd',['roles'=>$roles]);
    }
    /**
     * 管理员编辑
     * @return [type] [description]
     */
    public function adminedit(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->except(['password2']);
            if(empty($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = md5($data['password']);
            }
            $admin_id = $data['admin_id']; 
            $res = AdminModel::where('admin_id',$admin_id)
                            ->update($data);
            return response()->json(['code'=>1,'msg'=>'编辑成功']);              
        }
        $admin_id = $request->admin_id;
        $admin = AdminModel::find($admin_id);
        $roles = DB::table('admin_role')
                            ->get();
        return view('admin.admin.adminedit',['admin'=>$admin,'roles'=>$roles]);
    }
    /**
	 * 角色列表
	 */
    public function adminrole()
    {
        $datas = DB::table('admin_role')->paginate(5);
        $admins = DB::table('admin')->get();
    	return view('admin.admin.adminrole',['datas'=>$datas,'admins'=>$admins]);
    }
    /**
     * 添加角色
     */
    public function roleadd(Request $request)
    {
        if($request->isMethod('post')){
            $datas = $request->except(['admin-role-save']);
            $roles['role_name'] = $datas['role_name'];
            $roles['role_desc'] = $datas['desc'];
            // 判断角色是否选择权限
            if(!isset($datas['power_id'])){
                return ['code'=>0,'msg'=>'角色必须选择权限'];
            }else{
                $power_id = $datas['power_id'];
            }
            //角色入库 并获取角色id
            $role_id = DB::table('admin_role')
                            ->insertGetId($roles);
            //权限入库
            $access = [];
            foreach($power_id as $key=>$value){
                $access[$key]['role_id'] = $role_id;
                $access[$key]['power_id'] = $value;
            }
            $res = DB::table('access')
                        ->insert($access);
            if($res){
                return ['code'=>1,'msg'=>'添加成功'];
            }else{
                return ['code'=>0,'msg'=>'添加失败'];
            }
        }
        $parents = Permission::where('parent_id',0)
                                ->get();
        $sons = Permission::where('level',2)
                                ->get(); 
    	return view('admin.admin.roleadd',['parents'=>$parents,'sons'=>$sons]);
    }
    /**
     * 验证角色名是否存在
     * @return [type] [description]
     */
    public function checkrolename(Request $request)
    {
        $role_name = $request->role_name;
        //验证角色名是否被注册
        $roles = DB::table('admin_role')
                        ->where('role_name',$role_name)
                        ->count();
        if($roles){
            return 'false';
        }else{
            return 'true';
        }
    }
    /**
     * 角色编辑
     * @return [type] [description]
     */
    public function roleedit(Request $request)
    {   
        $role_id = $request->role_id;
        //获取所有的权限列表
        $module = DB::table('system_module')
                        ->where('parent_id',0)
                        ->get();
        $menu = [];
        $ids = [];
        foreach ($module as $key=>$parents) {
            $menu[$parents->mod_id] = $parents;
            $ids[] = $parents->mod_id;
        }
        $datas = DB::table('system_module')
                        ->where('level',2)
                        ->get();
        foreach($datas as $ke=>$val){
           $menu[$val->parent_id]->childs[]=$val;
            
        }
        $access = DB::table('access')
                        ->where('role_id',$role_id)
                        ->get();
        $power_id = [];
        foreach($access as $val){
            $power_id[] = $val->power_id;
        }
    	return view('admin.admin.roleedit',['menu'=>$menu,'power_id'=>$power_id]);
    }
    /**
     * 权限列表
     * @return [type] [description]
     */
    public function permission()
    {
        $datas = Permission::get();
        $parents = Permission::where('parent_id',0)
                                ->get();
        return view('admin.admin.adminpermission',['datas'=>$datas,'parents'=>$parents]);
    }
    /**
     * 添加权限
     * @return [type] [description]
     */
    public function permissionadd(Request $request)
    {
        if($request->isMethod('post')){
            $datas = $request->all();
            $parent_id = $datas['parent_id'];
            $result = Permission::where('title',$datas['title'])
                                ->count();
            if($result){
                return ['code'=>0,'msg'=>'该权限名称已被注册'];
            }
            if($parent_id == 0){
                $datas['level']=1;
            }else{
                $datas['level']=2;
            }
            //权限入库
            if(empty($datas['title'])){
                return ['code'=>0,'msg'=>'权限名称必须填写'];
            }else{
                $res = Permission::create($datas);
            }
            if($res){
                return ['code'=>1,'msg'=>'添加成功'];
            }else{
                return ['code'=>0,'msg'=>'添加失败'];
            }
        }
        $datas = Permission::where('parent_id',0)
                            ->get();
        return view('admin.admin.permissionadd',['datas'=>$datas]);
    }
}
