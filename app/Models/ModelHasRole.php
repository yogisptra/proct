<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ModelHasRole extends Model
{
    use HasFactory;

	protected $table = 'model_has_roles';

	protected $fillable = [
		'role_id', 'model_type', 'model_id'
	];

	public function hasRole()
	{
		return $this->belongsto(Role::class, 'role_id','id');
	}

	public function hasUser()
	{
		return $this->belongsto(User::class, 'model_id','id');
	}
}
