<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_corporate_details';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'nib', 'user_id', 'type_corporate', 'corporate_name', 'corporate_email', 'corporate_phone_number', 'corporate_address', 'corporate_country', 'corporate_province',
        'corporate_city', 'corporate_district', 'corporate_area', 'corporate_codepos', 'file_akta', 'image', 'nik_pic', 'name_pic', 'email_pic',
		'phone_number_pic', 'ktp_pic', 'image_selfie_pic', 'bio', 'linkedin', 'facebook', 'twitter', 'instagram', 'tiktok'
	];

    function hasUser()
	{
		return $this->belongsto(Donatur::class, 'user_id', 'id');
	}

	function hasTypeCorporate()
	{
		return $this->belongsTo(TypeCorporate::class, 'type_corporate', 'id');
	}

	function hasCountry()
	{
		return $this->belongsTo(SysCountry::class, 'corporate_country', 'id');
	}

	function hasProvince()
	{
		return $this->belongsTo(SysProvince::class, 'corporate_province', 'id');
	}

    function hasCity()
	{
		return $this->belongsTo(SysCity::class, 'corporate_city', 'id');
	}

    function hasDistrict()
	{
		return $this->belongsTo(SysDistrict::class, 'corporate_district', 'id');
	}

    function hasArea()
	{
		return $this->belongsTo(SysArea::class, 'corporate_area', 'id');
	}
    
    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}