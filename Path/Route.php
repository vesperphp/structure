<?php

/** This model is the mother of all
 * models within Vesper.
 */


namespace App\Path;

use App\Debug\Debug;
use App\SystemCache;
use App\Path\Request;
use App\System\Provider;

class Route{

    /**
     * 
     */

    public static function get($route, $controller, $access = false){

        
        $store = [
            'method' => 'GET',
            'app' => $controller,
            'route' => explode("/", $route),
            'route_flat' => $route,
            'access' => $access
        ];

        /**
         * When all the settings and parameters
         * are gathered we temporaily store this
         * data in the SystemCache.
         */

        SystemCache::store("GET:".$route, $store, "routes");

    }

    /**
     * 
     */

    public static function post($route, $controller, $access = false){

        $store = [
            'method' => 'POST',
            'app' => $controller,
            'route' => explode("/", $route),
            'route_flat' => $route,
            'access' => $access
        ];

        /**
         * When all the settings and parameters
         * are gathered we temporaily store this
         * data in the SystemCache.
         */

        SystemCache::store("POST:".$route, $store, "routes");

    }

    /**
     * This static function is ran on spin-up
     * so that all the routes will be gathered
     * and stored in a constant for later use.
     */

    public static function load(){

        require_once ROOTPATH."/routes.php";

        define("__ROUTES__", SystemCache::group("routes"));

    }

    /**
     * This method compares the defined routes from
     * the provider stream and the request data and
     * then stores the available info in the provider
     * stream for future use.
     */

    public static function compare(){
        
        
        $pull = new CompareRoute;

        $pull->collate();

        $pull->construct();
        
    }

}