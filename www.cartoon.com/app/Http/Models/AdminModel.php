<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = "admin";
    protected $primaryKey = "admin_id";
    protected $fillable = [
    	'admin_name','password','email','role_id','sex','desc','is_lock','add_time','last_login','login_count'
    ];
    public    $timestamps = false;
}
