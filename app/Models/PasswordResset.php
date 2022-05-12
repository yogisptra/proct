<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResset extends Model
{
    use HasFactory;

	protected $table = 'password_resets';

	protected $fillable = [
		'email', 'name', 'token', 'phone_number'
	];

	public function hasUserEmail()
    {
        return $this->belongsTo(Donatur::class, 'email', 'email');
    }

	public function hasUserPhone()
    {
        return $this->belongsTo(Donatur::class, 'phone_number', 'phone_number');
    }
}
