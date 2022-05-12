<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class CampaignList extends Model implements Viewable
{
    use HasFactory, HashId, InteractsWithViews;

	protected $table = 'ch_v_program_list';

	protected $primaryKey = 'id';
	public $incrementing = false;

    function hasUser()
	{
		return $this->belongsto(Donatur::class, 'user_id','id');
	}

    function hasCategory()
	{
		return $this->belongsto(Category::class, 'categories_id','id');
	}

	function hasCampaign()
	{
		return $this->belongsto(Campaign::class, 'id','id');
	}
    
    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}