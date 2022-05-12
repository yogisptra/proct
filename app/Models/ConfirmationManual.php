<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmationManual extends Model
{
    use HasFactory;

	protected $table = 'dns_manual_confirmations';
	protected $primaryKey = 'id';
    public $incrementing = false;

	protected $fillable = [
        'id', 'transaction_number', 'confirmation_date', 'amount', 'bank_account_id', 'image'
	];

    public function hasBankAccount()
	{
		return $this->belongsto(BankAccount::class, 'bank_account_id', 'id');
	}
}
