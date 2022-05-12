<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class Widhdrawal extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_widhdrawals';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'user_id', 'campaign_id', 'bank_account_id', 'request_date', 'amount', 'total_amount', 'percentage',
        'description', 'approval_date', 'status'
	];

	public function hasUser()
    {
        return $this->belongsTo(Donatur::class, 'user_id', 'id');
    }

	public function hasCampaign()
    {
        return $this->belongsTo(CampaignList::class, 'campaign_id', 'id');
    }

	public function hasBankAccount()
    {
        return $this->belongsTo(BankAccountCampaigner::class, 'bank_account_id', 'id');
    }

	// Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }
}