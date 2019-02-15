<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
    	return "我在测试控制器";
    }
    public function test()
    {
    	return view('admin.personalinfo');
    }
}
