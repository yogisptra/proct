<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class FAQCategory extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_faq_categories';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'name', 'description', 'created_by', 'updated_by', 'enabled'
	];
    
    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}