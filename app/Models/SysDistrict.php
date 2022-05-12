<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class SysDistrict extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_districts';
	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
		'id', 'name', 'enabled', 'country_id', 'province_id', 'city_id'
    ];

    public function province()
    {
        return $this->belongsTo(SysProvince::class, 'province_id', 'id');
    }
    
    public function country()
    {
        return $this->belongsTo(SysCountry::class, 'country_id', 'id');
    }

	public function city()
    {
        return $this->belongsTo(SysCity::class, 'city_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany(SysArea::class, 'area_id', 'id');
    }


}
