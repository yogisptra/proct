<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class CampaignUpdate extends Model
{
    use HasFactory, HashId;

	protected $table = 'dns_campaign_updates';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'campaign_id', 'title', 'content', 'created_by', 'updated_by', 'enabled'
	];
    
	public function hasCampaign()
	{
		return $this->belongsto(Campaign::class, 'campaign_id','id');
	}
    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}