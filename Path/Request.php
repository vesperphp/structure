<?php

/** This model is the mother of all
 * models within Vesper.
 */


namespace App\Path;

use App\Protect\Sanitize;

class Request{

    /**
     * Grab the path from the url
     * and make chocolate out off it.
     */

    public static function get(){

        if(!empty($_GET)){
            return Sanitize::array($_GET);
        }else{
            return ["p"=>"/"];
        }

    }

    /**
     * Grab the information from the
     * post request.
     */

    public static function post(){

        if(!empty($_POST)){
            return Sanitize::array($_POST);
        }else{
            return ["p"=>"/"];
        }

    }

    /**
     * Determine the request type.
     */

     public static function type(){

        if(empty($_POST)){
            return "GET";
        }else{
            return "POST";
        }

    }



}