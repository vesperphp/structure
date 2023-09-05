<?php

/**
 * This class helps with redirecting
 */

namespace App\Path;

use App\System\Provider;
use App\Debug\Log;



class Redirect{

    public static function error($type=404, $details='generic'){

        $env = Provider::get("ENV");
        $url = rtrim($env['system']['url'],"/").'/'.$type;

        Log::to([Request::get(), "Redirect type" => $type, "Details" => $details], 'redirect');

        header("Location: ".$url);
        
        die('redirect to '.$url);
 
    }

}