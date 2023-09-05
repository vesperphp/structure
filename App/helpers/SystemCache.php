<?php

/**
 * The SystemCache is a SESSION that is wiped
 * when the page is loaded and everything is
 * placed properly. Used for temporarily storing
 * data and transfering from one class to
 * the other.
 */

namespace App;

class SystemCache{

    /**
     * Store something in the SystemCache.
     */

    public static function store($name, $value, $group = "init"){

        $_SESSION['SystemCache'][$group][$name] = $value;

    }

    /**
     * Get all data within a Cache group.
     */
    
    public static function group($group){

        return $_SESSION['SystemCache'][$group];

    }

    /**
     * Clear this said cache.
     */

    public static function drop(){

        unset($_SESSION['SystemCache']);

    }
    
}
