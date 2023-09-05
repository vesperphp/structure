<?php 

/**
 * The provider is the place where all information needed 
 * a cycle (boot up, gather, boot down) is stored.
 */ 

namespace App\System;

use App\SystemCache;

class Provider{

    public static function cache(){
        
        /**
         * Store all information
         * provided by constants
         * into the system cache
         * linked to the provider.
         */

        SystemCache::store("ENV", __ENV__, "PROVIDER");
        SystemCache::store("ROUTES", __ROUTES__, "PROVIDER");
        
    }

    public static function all(){
        
        return SystemCache::group("PROVIDER");
        
    }

    public static function get($group = "ENV"){

        /**
         * Get all the data 
         * from the provider.
         */

        $p = Provider::all();

        /**
         * Check if the requested
         * group exists and if
         * so return values.
         */

        if(isset($p[$group])){
            return $p[$group];
        }else{
            return NULL;
        }


    }

    /**
     * Store or rewrite data to the provider system.
     */

    public static function store($name, $values){
        
        SystemCache::store($name, $values, "PROVIDER");

    }

    /**
     * Remove data from the provider stream. A ghost 
     * will remain... but NULL..
     */

    public static function drop($name){
        
        SystemCache::store($name, NULL, "PROVIDER");
        
    }

}