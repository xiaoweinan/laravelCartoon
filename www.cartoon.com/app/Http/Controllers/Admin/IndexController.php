<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use DB;
class IndexController extends Controller
{
	/**
	 * 后台首页
	 * @return [type] [description]
	 */
    public function index()
    {
        $role_id = Session::get('roleinfo')->role_id;
        $access = DB::table('access')
                    ->where('role_id',$role_id)
                    ->get();
        //菜单分组
        $mod_id = [];
        foreach($access as $key=>$value){
            $mod_id[] = $value->power_id;
        }
        $powers = DB::table('system_module')
                    ->whereIn('mod_id', $mod_id)
                    ->where('level',1)
                    ->get();
        $menu = [];
        $ids = [];
        foreach($powers as $key=>$value){
            $menu[$value->mod_id] = $value;
            $ids[] = $value->mod_id;
        }
        $childs = DB::table('system_module')
                        ->whereIn('parent_id',$ids)
                        ->get();
       foreach ($childs as $key=>$value) {
           $menu[$value->parent_id]->childs[]=$value;
       }
       // dump($menu);
        return view('admin.index.index',['menu'=>$menu,'access'=>$access]);
    }
    /**
     * 后台欢迎页面
     * @return [type] [description]
     */
    public function welcome()
    {
    	return view('admin.index.welcome');
    }
}

