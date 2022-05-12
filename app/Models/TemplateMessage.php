<?php

namespace App\Models;

use App\DigiBase\Utilities\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TemplateMessage extends Model
{
    use HasFactory, HashId;
    use Notifiable;

	protected $table = 'dns_templates';

	protected $primaryKey = 'id';
	public $incrementing = false;
	protected $fillable = [
		'id', 'name', 'message', 'description', 'type', 'created_by', 'updated_by', 'enabled'
	];

	public function hasUser()
	{
		return $this->belongsTo(User::class, 'created_by', 'id');
	}
}