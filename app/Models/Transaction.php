<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class Transaction extends Model
{
    use HashId;

    protected $table = 'dns_transactions';

	protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'campaign_id', 'type_transaction_id', 'donation_type', 'donatur_id', 'bank_account_id', 'fundraiser_id', 'transaction_number',
        'transaction_date', 'payment_date', 'transaction_status_id', 'unique_code', 'amount', 'payment_method', 'note', 'name', 'email', 'phone_number', 'referral', 'transaction_via', 'is_hamba_allah', 'is_delete',
        'va_number', 'bill_key', 'biller_code', 'payment_code', 'qr_code', 'link', 'expired_date'
    ];

    function hasBankAccount()
	{
		return $this->belongsto(BankAccount::class, 'bank_account_id','id');
	}

    function hasUser()
	{
		return $this->belongsto(Donatur::class, 'donatur_id','id');
	}

    function hasCampaign()
	{
		return $this->belongsto(Campaign::class, 'campaign_id','id');
	}

    function hasCampaignList()
	{
		return $this->belongsto(CampaignList::class, 'campaign_id','id');
	}

    function hasFundraiser()
	{
		return $this->belongsto(Donatur::class, 'fundraiser_id','id');
	}

    function hasLikes()
	{
		return $this->hasMany(Like::class, 'transaction_id','id');
	}
}
