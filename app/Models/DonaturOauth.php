<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class DonaturOauth extends Model
{
    use HashId;

    protected $table = 'dns_donaturs-oauth';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'donatur_id', 'avatar', 'provider', 'provider_uid', 'access_token', 'refresh_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'refresh_token',
    ];

    /** Relational Attributes Start */

    /** Relational Attributes End */
}
