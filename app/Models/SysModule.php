<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysModule extends Model
{
    use HasFactory;

	protected $table = 'sys_modules';

	protected $primaryKey = 'id';

	protected $fillable = [
		'id', 'name', 'description', 'sequence', 'icon', 'enabled'
	];

	public function hasMenu()
	{
		return $this->hasMany(SysMenu::class, 'module_id','id')->orderBy('sequence', 'ASC');
	}
}
