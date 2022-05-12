<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class TransactionDetail extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_transaction_details';

	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $fillable = [
		'id', 'type_transaction_id',  'name', 'description', 'enabled', 'created_by', 'updated_by'
	];

	public function hasTransactionType()
	{
		return $this->belongsto(TransactionType::class, 'type_transaction_id','id');
	}

	/**
     * Scope for filter data from models
     *
     * @return query result
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
