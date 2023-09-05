<?php

/**
 * Comparing the route and
 * path is no easy thing
 * to do...
 */


namespace App\Path;

use App\Debug\Debug;
use App\Path\Request;
use App\System\Provider;

class CompareRoute{

    public $routes = "";
    public $path = "";
    public $explodedPath = array();
    public $pathCount = 0;
    public $foundRoute = array();

    public function __construct(){

        /**
         * Pull the routing data.
         */

        $this->routes = Provider::get("ROUTES");

        /**
         * Sort out all the path information.
         */

        $this->path = Request::get();


        if($this->path['p']=="/"){
            $this->explodedPath = ['/'];
        }else{
            $this->explodedPath = explode("/", rtrim($this->path['p'], "/"));
        }

        $this->pathCount = count($this->explodedPath);

    }

   
    /**
     * This is the big comparator for 
     * the routing system. It compares the exploded paths
     * to the paths in the routing stream.
     */

    public function collate(){

        /**
         * Are we on the homepage?
         */

        if($this->path['p']=="/"){

            $this->foundRoute = array_merge(
                $this->routes['GET:/'],[
                        'request' => [
                            'path' => $this->path['p'], 
                            'exploded_path' => $this->explodedPath, 
                            ]
                        ]);   
            return;
            
        }

        /**
         * If we are not on the homepage
         * let's compare every defined
         * route with the path from the
         * request.
         */
        
        $set = false;
        foreach($this->routes as $id => $route){

            $count = 0;
            $compare = $route['route'];
            $variable = [];

            /**
             * Every route partial is checked
             * against the path element in that 
             * array spot. But first we check if
             * the amount of partials is the same
             * as the path partials. This means
             * we can skip some comparisons.
             */

            if($this->pathCount == count($compare)){

                /**
                 * Then we can willow out the
                 * request types that are not
                 * needed in this loop.
                 */
                
                if(Request::type()==$route['method']){

                    /**
                     * Run every partial against the
                     * path partials.
                     */

                    $i =  0;
                    $count = 0;

                    foreach($compare as $partial){

                        /**
                         * Is the position in the path
                         * a variable or a regular
                         * path denominator? */                        

                        if(str_ends_with($partial, "}") AND str_starts_with($partial, "{")){
                            
                            $varname = str_replace(["{", "}"], "", $partial);
                            $variable[$varname] = $this->explodedPath[$i];
                            $count++;

                        }else{
                            if($partial == $this->explodedPath[$i]){
                                $count++;
                            }
                        }

                        $i++;

                    } // foreach

                } // request type

            } // not the same length

            /**
             * When we have found a match, then
             * we should populate this instance 
             * with the data aquired.
             */

            if($count == $this->pathCount){

                $this->foundRoute = array_merge(
                    $route, [
                        "variables" => $variable
                        ], [
                            'request' => [
                                'path' => $this->path['p'], 
                                'exploded_path' => $this->explodedPath, 
                                ]
                            ]);

                $set = true;

            }

        } // foreach

        /**
         * This is the fallback position. 
         * In case no route is matched the
         * 404 page will kick in.
         */

        if($set == false){
         
                $this->foundRoute = array_merge(
                    $this->routes['GET:404'],[
                            'request' => [
                                'path' => $this->path['p'], 
                                'exploded_path' => $this->explodedPath, 
                                ]
                            ]);                
        
        }
        

    }

    /**
     * Then we store all the routing 
     * data in the provider stream.
     */
    
    public function construct(){


        if(!empty($this->foundRoute)){

            Provider::store("CURRENT_ROUTE", $this->foundRoute);

        }


    }

}