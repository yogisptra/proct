<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;

	protected $table = 'sys_transaction_types';
	public $incrementing = false;

	protected $primaryKey = 'id';

	protected $fillable = [
		'id', 'name', 'description', 'enabled', 'created_by', 'updated_by'
	];

	public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
