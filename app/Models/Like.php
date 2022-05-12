<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_likes';

	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $fillable = [
		'id', 'donatur_id', 'campaigner_id', 'campaign_id', 'transaction_id'
	];

    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}