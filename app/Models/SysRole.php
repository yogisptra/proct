<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use App\DigiBase\Utilities\HashId;

class SysRole extends Role
{
    use HasFactory, HashId;
	protected $table = 'roles';

	protected $primaryKey = 'id';

	protected $fillable = [
        'id', 'name', 'enabled', 'guard_name'
	];

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
