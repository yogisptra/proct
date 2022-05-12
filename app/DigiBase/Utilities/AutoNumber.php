<?php

namespace App\DigiBase\Utilities;

use Illuminate\Support\Facades\DB;

/**
 *  this trait for generate autoNumber
 */
trait AutoNumber
{
    public function GenerateAutoNumber($tableName){
        $total_data_today = DB::table($tableName)->whereDate('created_at', date('Y-m-d'))->count();
        return date('Ymd').str_pad($total_data_today + 1, 3, "0", STR_PAD_LEFT);
    }

    /**
     * Function to generate number
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */ 
    public function generateNumeric($n) { 
        
        // random number
        $generator = "1357902468"; 
        $result = ""; 
    
        for ($i = 1; $i <= $n; $i++) { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
    
        return $result; 
    } 
}
