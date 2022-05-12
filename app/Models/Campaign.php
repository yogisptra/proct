<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Campaign extends Model implements Viewable
{
    use HasFactory, HashId, InteractsWithViews;

	protected $table = 'dns_campaigns';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'categories_id', 'user_id', 'title', 'target', 'custom_amount', 'valid_date', 'open_goal',
		'description', 'image', 'background', 'slug', 'main_program', 'enabled', 'fb_pixel', 'gtm', 'enabled'
	];

	function hasUser()
	{
		return $this->belongsto(Donatur::class, 'user_id','id');
	}

    function hasCategory()
	{
		return $this->belongsto(Category::class, 'categories_id','id');
	}
    
    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}