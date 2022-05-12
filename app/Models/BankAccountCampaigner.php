<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class BankAccountCampaigner extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_bank_account_campaigners';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'bank_id', 'user_id', 'account_name', 'account_number', 'description'
	];

	function hasBank()
	{
		return $this->belongsto(Bank::class, 'bank_id','id');
	}

    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}