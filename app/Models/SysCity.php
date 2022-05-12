<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class SysCity extends Model
{
    use HasFactory, HashId;

    protected $table = 'sys_cities';
	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
		'id', 'name', 'enabled', 'country_id', 'province_id'
	];

    public function country()
    {
        return $this->belongsTo(SysCountry::class, 'country_id', 'id');
    }
    
	public function province()
    {
        return $this->belongsTo(SysProvince::class, 'province_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany(SysDistrict::class, 'district_id', 'id');
    }


}
