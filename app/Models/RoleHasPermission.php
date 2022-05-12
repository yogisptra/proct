<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermission extends Model
{
    use HasFactory;

	protected $table = 'role_has_permissions';

	protected $fillable = [
		'permission_id', 'role_id'
	];

	public function hasPermission()
	{
		return $this->belongsto(Permission::class, 'permission_id','id');
	}

	public function hasRole()
	{
		return $this->belongsto(Role::class, 'role_id','id');
	}
}
