<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_notification_logs';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'subject', 'type', 'description', 'to', 'from', 'is_read'
	];
    
    // Relation for Multiple Post
	// function createRelation()
    // {
    //     return $this->hasMany('App\Models\YourModel','your_id');
    // }

}