<?php

/**
 * This class pulls the controller information from 
 * the Provider stream and gets all the things together.
 * Also triggers the access information
 */

namespace App;

use App\System\Provider;
use App\Path\Redirect;
use App\Debug\Debug;

class SystemController{


    public static function paint(){


        $currentRoute = Provider::get("CURRENT_ROUTE");

        $controller = $currentRoute['app'][0];
        $method = $currentRoute['app'][1];
        $access = $currentRoute['access'];

        /**
         * First of all, do we have access
         * to this page?
         */

        if(is_array($access)){

            /**
             * This runs when access is filled
             * and restrictions are in effect.
             */

             foreach($access as $checkpoint){

                $cp_controller = $checkpoint[0];
                $cp_method = $checkpoint[1];

                if(class_exists($cp_controller) AND method_exists($cp_controller, $cp_method)){

                    $spin = new $cp_controller;
                    $spin->$cp_method();
                }else{
                    
                    Redirect::error(403);
                }
                
             }

        }

        /**
         * Do the class and method within exist?
         */

        if(class_exists($controller) AND method_exists($controller, $method)){
            
            header("HTTP/1.0 200 OK");
            $spin = new $controller;
            $spin->$method();

        }else{

            /**
             * If the class or method do
             * not exist... then redirect
             * to the 404 page.
             */
        
            Redirect::error();

        }
        
        

    }


    
}
