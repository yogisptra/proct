<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class SysPermission extends Permission
{
    use HasFactory;
	protected $table = 'permissions';

	protected $primaryKey = 'id';

	protected $fillable = [
        'id', 'name', 'type', 'guard_name'
	];
}
