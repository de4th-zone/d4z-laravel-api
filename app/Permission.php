<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permission';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function RolePermission()
    {
    	return $this->hasMany('App\RolePermission', 'permission_id', 'id');
    }

    public function Role()
    {
        return $this->belongsToMany('App\Role', 'role_permission');
    }
}
