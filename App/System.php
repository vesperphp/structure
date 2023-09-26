<?php

/** This is the backbone of the entire app. This class will
 * be executed from the index.php as a homepage. The rest
 * will be loaded trough this class.
 */

namespace App;

use App\SystemEnv;
use App\SystemController;
use App\SystemCache;
use App\Debug\Debug;
use App\System\Provider;
use App\Path\Route;

class System{

    public function spinUp(){
        
        /**
         * Initialize the system. 
         * Fetching all settings,
         * routes and other data.
         */

        SystemEnv::load();  
        Route::load();      
        Provider::cache();  
        /** 
         * We compare the routing information
         * with the fetched path from the GET
         * variable.
         */

        Route::compare();

    }

    /**
     * When we are done with showing the page
     * we can remove all the caching and be
     * done with it.
     */

    public function spinDown(){

        // Debug data, show the provider stream.
        Debug::dump(Provider::all());

        /**
         * Clear the system cache.
         */

        SystemCache::drop();

    }

    /**
     * All the information that is stored
     * in the provider stream can be pulled
     * and the controller accessed.
     */

    public function pullController(){

        /**
         * Use the gathered info
         * to build up the page
         * and check for access
         * reguirements.
         */
        
        SystemController::paint();

    }

}