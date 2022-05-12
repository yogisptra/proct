<?php

namespace App\DigiBase\Controller;

use App\DigiBase\Utilities\AutoNumber;
use App\DigiBase\Utilities\LoadMenu;
use App\DigiBase\Utilities\HashId;
use App\Http\Controllers\Controller;
use App\DigiBase\Utilities\Session;


class BaseController extends Controller{
    use AutoNumber, LoadMenu, HashId, Session ;

    public function loadData()
    {
        view()->share('activeMenu', $this->ActiveMenu());
    }
    
    protected function makeView($viewname,$data = array()){
        $this->loadData();
		if(!is_array($data)){
			$data = array();
		}
    	return view()->make($viewname, $data);
	}

	protected function goTo401Page($exc)
    {
        $this->loadData();

        if (config('debug', false) == true) {
            return abort(401, $exc);
        } else {
            throw $exc;
        }
    }

    protected function goTo403Page($exc)
    {
        $this->loadData();

        if (config('debug', false) == true) {
            return abort(403, $exc);
        } else {
            throw $exc;
        }
    }

    protected function goTo404Page($exc)
    {
        $this->loadData();

        if (config('debug', false) == true) {
            return abort(404, $exc);
        } else {
            throw $exc;
        }
    }

    protected function goTo500Page($exc)
    {
        $this->loadData();

        if (config('debug', false) == true) {
            return abort(500, $exc);
        } else {
            throw $exc;
        }
    }
}