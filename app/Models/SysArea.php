<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class SysArea extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_areas';
	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
		'id', 'name', 'enabled', 'country_id', 'province_id', 'city_id', 'district_id'
	];

	public function country()
    {
        return $this->belongsTo(SysCountry::class, 'country_id', 'id');
	}

	public function province()
    {
        return $this->belongsTo(SysProvince::class, 'province_id', 'id');
    }

	public function city()
    {
        return $this->belongsTo(SysCity::class, 'city_id', 'id');
    }
	
    public function district()
    {
        return $this->belongsTo(SysDistrict::class, 'district_id', 'id');
    }


}
