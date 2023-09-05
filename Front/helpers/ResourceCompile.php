<?php

/**
 * This class helps with redirecting
 */

namespace App\Front;


class ResourceCompile{


    public static function stylesheet(){


        $css = '';

        /**
         * Load the settings file..
         */

        include(ROOTPATH."/App/Resource/css.php");

        /**
         * Load all the PHP files
         * with CSS buildup in them....
         */

        foreach (glob(ROOTPATH."/App/Resource/partials/*.php") as $filename){ include_once $filename; }

        // Write this to file(s)
        echo $css;

        // build file

    }

}