<?php

/**
 * This class helps with redirecting
 */

namespace App\Front;

use App\Debug\Log;

use App\Front\ViewCompiler;


class View{

    static $pathCache;
    static $pathViews;
    static $cache; 

    public static function print(string $file){

        include_once self::cache($file);
 
    }

    public static function email(string $file){

        return self::cache($file);
 
    }

    public static function cache(string $file) {

        self::$pathCache = ROOTPATH.'/public_html/cache/';
        self::$pathViews = ROOTPATH.'/App/Views';
        self::$cache = 'xxx'; 

        /**
         * Check if the cache folder exists
         * and if not, create a cache folder
         * on that spot (see config)
         */

        if (!file_exists(self::$pathCache)) { mkdir(self::$pathCache, 0744); }
        
        /**
         * Set up a proper string (dir_file.php)
         * for the cached file. This will become
         * a PHP file.
         */

        $fileName = str_replace(array('/', '.html'), array('_', ''), $file . '.php');
        $fileCache = self::$pathCache . $fileName; 
        $fileViews = self::$pathViews . $file;

        /**
         * Let's do a check if the parameters are met and
         * we are good to go on creating a new cached file:
         * 
         * - Check if production mode is off.
         * - Check if the file already exists.
         * - Check if the cached file is older (smaller)
         *   than the template file.
         */

        if (self::$cache || !file_exists($fileCache) || filemtime($fileCache) < filemtime($fileViews)) {
            
            /**
             * Pull the file from the Views folder
             * via the Compiler class.
             */
           
            $source = ViewCompiler::run($file);

            /**
             * Add the class and some namespace 
             * routes to the top of the cached 
             * php files.
             */

            $namespaces = [
                
            ];

            /**
             * Create a string from the namespace
             * array for presenting.
             */

            $use = "\n";
            foreach($namespaces as $space){ $use .= "use ".$space.";\n"; }

            file_put_contents($fileCache, "<?php \nclass_exists(\"" . __CLASS__ . "\") or exit; ".$use."?>" . PHP_EOL . $source);

            Log::to(['cached'=>$fileName],'view');

        }

        /**
         * Return the path of the cached file
         * for the view method to present.
         */

        return $fileCache;
        

    }
    
}

