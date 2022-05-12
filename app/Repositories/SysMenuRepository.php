<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\SysMenu;
use Illuminate\Http\Request;
use DB, Cacth, Auth;

class SysMenuRepository extends Apprepository{
    protected $model;

    public function __construct(SysMenu $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {
		if($request['shown'] == 'with-authorize'){
			$shown = str_replace(" ", "-", strtolower($request->input('name')).'-list');
		}elseif($request['shown'] == null){
			$shown = 'without-authorize';
		}else {
			$shown = $request['shown'];
		}

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'parent_id' 	=> isset($request['parent_id']) ? $request->input('parent_id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'description' 	=> isset($request['description']) ? $request->input('description') : null,
            'route' 		=> isset($request['route']) ? $request->input('route') : null,
            'sequence'	 	=> isset($request['sequence'	]) ? $request->input('sequence'	) : null,
            'icon'	 		=> isset($request['icon'	]) ? $request->input('icon'	) : null,
            'enabled' 		=> isset($request['enabled']) ? 1 : 0,
            'shown' 		=> $shown,
        ];
    }

    public function paginate(Request $request)
    {
       
        $data = $this->model
                    ->when(request()->search, function($query) {
                        $query->where('name', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

}