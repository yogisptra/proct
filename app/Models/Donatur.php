<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\DigiBase\Utilities\HashId;

class Donatur extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HashId;

	protected $table = 'dns_donaturs';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nik', 'name', 'email', 'phone_number', 'password', 'image', 'gender', 'address', 'enabled', 'birth_date',
        'birth_place', 'country_id','province_id','city_id','district_id','area_id', 'codepos', 'religion','bio','nationality','domicile', 'api_token','remember_token','otp','email_verified',
        'activated','otp','type_campaigner','is_campaigner', 'image_ktp', 'image_selfie', 'facebook', 'instagram', 'twitter', 'linkedin', 'tiktok',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function hasCorporate()
	{
		return $this->hasOne(Corporate::class, 'user_id', 'id');
	}

    function hasProvince()
	{
		return $this->belongsTo(SysProvince::class, 'province_id', 'id');
	}

    function hasCity()
	{
		return $this->belongsTo(SysCity::class, 'city_id', 'id');
	}

    function hasDistrict()
	{
		return $this->belongsTo(SysDistrict::class, 'district_id', 'id');
	}

    function hasArea()
	{
		return $this->belongsTo(SysArea::class, 'area_id', 'id');
	}
}
