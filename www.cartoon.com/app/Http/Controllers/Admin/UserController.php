<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
    	$username = "小花";
    	$html = "<a href=>你是傻屌</a>";
    	$nums = [1,2,3,4,5];
    	return view('admin.userindex',['username'=>$username,'html'=>$html,'nums'=>$nums]);
    }
}
