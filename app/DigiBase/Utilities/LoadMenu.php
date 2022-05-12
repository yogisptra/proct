<?php

namespace App\DigiBase\Utilities;

use Illuminate\Support\Facades\DB;
use App\Models\SysModule;
use App\Models\SysMenu;

trait LoadMenu
{
    public function ActiveMenu(){
		$singleMenu = SysMenu::where('enabled', 1)
				->whereNull('parent_id')
				->whereNotNull('route')
				->whereNotIn('id', function($query){
						$query->select('parent_id')
						->from('sys_menus')
						->where('enabled', 1)
						->whereNotNull('parent_id');
					})
				->get();

		$multiMenu =  SysMenu::where('enabled', 1)
				->whereNull('parent_id')
				->whereIn('id', function($query){
						$query->select('parent_id')
						->from('sys_menus')
						->where('enabled', 1)
						->whereNotNull('parent_id');
					})
				->get();

		$menu = [];
		for($i = 0 ; $i < count($singleMenu); $i++){
			$menu[] = $singleMenu[$i];
		}
		for($j = 0 ; $j < count($multiMenu); $j++){
			$menu[] = $multiMenu[$j];
		}

		//dd($multiMenu);
		$keys = array_column($menu, 'sequence');
		array_multisort($keys, SORT_ASC, $menu);
		return $menu;

    	//return $data_module =  SysModule::whereIn('id',function ($query) {
    	//    $query->select('module_id')->from('sys_menus')
    	//    ->Where('enabled', 1);
    	//})
    	//->Where('enabled', 1)
		//->orderBy('sequence', 'ASC')
		//->get();
    }
}
