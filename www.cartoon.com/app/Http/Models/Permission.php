<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "system_module";
    protected $primaryKey = "mod_id";
    protected $fillable = [
    	'level','route','title','parent_id','orderby','icon'
    ];
    public    $timestamps = false;
}
