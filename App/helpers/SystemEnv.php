<?php

/**
 * Handling the enviroment file.
 */

namespace App;

class SystemEnv{

    /**
     * Load the enviroment file and store 
     * everything in a constant.
     */

    public static function load(){

        require_once ROOTPATH."/env.php";
        define("__ENV__", $a);

    }


    
}
