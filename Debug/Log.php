<?php

/**
 * Some logger functionalities
 */

namespace App\Debug;

class Log {

    /**
     * Make a log entry in a specified log
     * file or the standard system log.
     */
    
    public static function to(array $array, string $file='vesper'){

        if(!is_array($array)){
            $array=[$array];
        }

        /**
         * Make sure that the
         * logging entity
         * exists in config.
         */

        //if(Config::get('logger/'.$file)){

            $uri = ''; // full url should go here
            self::logFile($file,$uri,$array);

        //}
        
    }
    
    /**
     * This static handles the file handling.
     */

    private static function logFile(string $sev, string $name, array $array){

        /**
         * Populate all variables such as
         * filename, directory and the full path.
         */
        
        $dir = ROOTPATH."/Private/Logs/";
        $filename = date("Ymd").'_'.$sev.'.log';
        $filestring = $dir.$filename;

        /**
         * If the storage folder does not exist, 
         * then create it.
         */
        
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);

        }
        /**
         * Does the file already exist?
         * If it does not, create it.
         */

        if(!file_exists($filestring)){

            /**
             * Create a new file.
             * Start the file with a header.
             */
            
            $newFile = fopen($filestring, "w") or die("Unable to open file!");
        
            $txt = "Log started on ".date("Y-m-d H:i:s")."\n-----\n";
            fwrite($newFile, $txt);

            /**
             * Prepare the logging statement.
             */

            $txt = date("H:i").'[ '.$name.' ]'."\n";
            fwrite($newFile, $txt);

            /**
             * Modify the array so that is
             * makes nice lines in the log.
             */
            
            foreach($array as $key => $val){

                if(is_array($val)){

                    $string = '';
                    foreach($val as $name => $part){    

                        $string .= '[ '. $name .' = '. $part .' ] ';

                    }

                    $txt = '  - '.$string."\n";
                    fwrite($newFile, $txt);

                }else{

                    $txt = '- '.$key.': '.$val."\n";
                    fwrite($newFile, $txt);

                }
            } 
            
            $txt = "-----\n";
            fwrite($newFile, $txt);

            /**
             * And close the file.
             */
            
            fclose($newFile);

        }else{
                    
            /**
             * Open the existing logfile.
             */
            
            $newFile = fopen($filestring, "a") or die("Unable to open file!");

            /**
             * Prepare the logging statement.
             */
            
            $txt = date("H:i").'[ '.$name.' ]'."\n";
            fwrite($newFile, $txt);

            /**
             * Modify the array so that is
             * makes nice lines in the log.
             */
            
            foreach($array as $key => $val){

                if(is_array($val)){

                    $string = '';
                    foreach($val as $name => $part){    

                        $string .= '[ '. $name .' = '. print_r($part, true) .' ] ';
                        

                    }

                    $txt = '  - '.$string."\n";
                    fwrite($newFile, $txt);

                }else{

                    $txt = '- '.$key.': '.$val."\n";
                    fwrite($newFile, $txt);
                    
                }
            } 
            
            $txt = "-----\n";
            fwrite($newFile, $txt);

            /**
             * And close the file.
             */
            
            fclose($newFile);
        }

    }



}
