<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DigiBase\Utilities\HashId;

class SysMenu extends Model
{
    use HasFactory, HashId;

	protected $table = 'sys_menus';

	protected $primaryKey = 'id';

	protected $fillable = [
		'id', 'module_id', 'parent_id','name', 'description', 'route', 'sequence', 'icon', 'enabled', 'shown'
	];

    public function childs() {
        return $this->hasMany('App\Models\SysMenu','parent_id','id')->where('enabled', 1)->orderBy('sequence', 'ASC') ;
    }

    public function hasParent($parent_id) {
        $hasParent = SysMenu::where('id', $parent_id)->first() ;

		if($hasParent != null){
			return $hasParent->name;
		}
		return '-';
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
