<?php

/**
 * Handling the enviroment file.
 */

namespace App;

class SystemEnv{

    /**
     * Load the enviroment file and store 
     * everything in the loop.
     */

    public static function load(){

        require_once ROOTPATH."/env.php";

        return $a;

    }


    
}
