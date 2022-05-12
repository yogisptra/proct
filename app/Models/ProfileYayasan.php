<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ProfileYayasan extends Model
{
    use HasFactory, Notifiable;

	protected $table = 'sys_profile_instations';

	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
		'id', 'name', 'description', 'image_url', 'address', 'website', 'email', 'phone_number', 'social_media', 'created_by', 'updated_by'
	];


}
