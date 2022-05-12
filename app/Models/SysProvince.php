<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class SysProvince extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_provinces';
	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
		'id', 'name', 'enabled', 'country_id'
	];

	public function country()
    {
        return $this->belongsTo(SysCountry::class, 'country_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(SysCity::class, 'city_id', 'id');
    }



}
