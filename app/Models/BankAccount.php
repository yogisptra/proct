<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_bank_accounts';

	protected $primaryKey = 'id';
	public $incrementing = false;
	public $with = ['hasBank'];
	protected $fillable = [
		'id', 'account_name', 'account_number', 'bank_id', 'type', 'created_by', 'updated_by', 'enabled'
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