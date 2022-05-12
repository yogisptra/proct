<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\SysModule;
use Illuminate\Http\Request;

class SysModuleRepository extends Apprepository{
    protected $model;

    public function __construct(SysModule $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'description' 	=> isset($request['description']) ? $request->input('description') : null,
            'sequence'	 	=> isset($request['sequence'	]) ? $request->input('sequence'	) : null,
            'icon'	 		=> isset($request['icon'	]) ? $request->input('icon'	) : null,
            'enabled' 		=> isset($request['enabled']) ? $request->input('enabled') : null,
        ];
    }

}