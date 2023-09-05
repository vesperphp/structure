<?php

namespace App\Protect;

class Sanitize{

    /**
     * Use addslashes on a 
     * single value.
     */

    public static function addslashes($i){

        return addslashes($i);

    }

    /**
     * Sanitize an array worth
     * of values.
     */

     public static function array($i){

        return array_map("addslashes", $i);

     }

}