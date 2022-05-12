<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class FAQDescription extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_faq_descriptions';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'faq_categories_id', 'type', 'answer', 'question', 'keyword', 'created_by', 'updated_by', 'enabled'
	];

	function hasFaqCategory()
	{
		return $this->belongsto(FAQCategory::class, 'faq_categories_id','id');
	}

    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}