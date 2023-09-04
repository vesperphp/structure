<?php 

namespace App\System;

use App\SystemEnv;

class Provider{

    public static function all(){
        
        return SystemEnv::load();
        
    }

    public static function get(){

    }

    public static function store(){
        
    }

    public static function drop(){
        
    }

}