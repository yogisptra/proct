<?php

namespace App\DigiBase\Utilities;

use Hashids\Hashids;

trait Hashid{
    public function encodeHash($value){
        $hashids = new Hashids(env('APP_KEY'),6);
        return $hashids->encode($value);
    }

    public function decodeHash($value){
        $hashids = new Hashids(env('APP_KEY'),6);
        return $hashids->decode($value)[0];
    }
}