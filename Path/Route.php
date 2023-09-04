<?php

/** This model is the mother of all
 * models within Vesper.
 */


namespace App\Path;

use App\Debug\Debug;

class Route{

    public static function get($a, $b){
        Debug::dump($b);
    }

    public static function load(){

        require_once ROOTPATH."/routes.php";

    }

}