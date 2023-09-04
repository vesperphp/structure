<?php

/** This is the backbone of the entire app. This class will
 * be executed from the index.php as a homepage. The rest
 * will be loaded trough this class.
 */


namespace App;

use App\Path\Route;
use App\SystemEnv;


class System{

    public function spin(){

        
        SystemEnv::load();
        
        echo "we are running<br>";

        Route::load();
        
        
    }

}