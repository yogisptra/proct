<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class SysCountry extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_countries';
	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
		'id', 'name', 'enabled'
	];

	public function provinces()
    {
        return $this->hasMany(SysProvince::class, 'province_id', 'id');
    }


}
