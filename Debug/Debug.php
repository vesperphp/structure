<?php

/**
 * The Debugging package within Vesper. Will be
 * put to good use!
 */

namespace App\Debug;

class Debug{

    public static function dump($a){

        DebugStyle::css();
        
        echo "<div class='vesper-debug'>";

        echo "<h2 class='debug-subtitle'>Debug Dump</h2>";
        echo "<div class='debug-timestamp'><i>Ran via Debug::dump() on ".date("Y/m/d H:i")."</div>";

        echo "<pre>";

        var_dump($a);
        Log::to($a, 'debug');

        echo "</pre>";

            ?><button onclick='debugToggle("debugBacktrace")' class="debug-toggle-button">Show the debug backtrace</button><?php

            echo "<div id='debugBacktrace' class='hidden'>";
            echo "<h3 class='debug-subtitle'>Debug Backtrace</h3>";
            DebugStyle::table(debug_backtrace());
            echo "</div>";

            ?><button onclick='debugToggle("declaredClasses")' class="debug-toggle-button">Show all declared classes</button><?php
            echo "<div id='declaredClasses' class='hidden'>";
            echo "<h3 class='debug-subtitle'>All declared classes</h3>";
            DebugStyle::table(get_declared_classes());
            echo "</div>";

            ?><button onclick='debugToggle("lastPhpError")' class="debug-toggle-button">Show last captured PHP errror</button><?php

            echo "<div id='lastPhpError' class='hidden'>";
            echo "<h3 class='debug-subtitle'>Last PHP error</h3>";
            DebugStyle::table(error_get_last());
            echo "</div>";

            ?><button onclick='debugToggle("phpInfo")' class="debug-toggle-button">Show all PHPinfo</button><?php
            echo "<div id='phpInfo' class='hidden'>";
            echo "<h3 class='debug-subtitle'>PHP Info</h3>";
            DebugStyle::table(Debug::info());
            echo "</div>";

  
        DebugStyle::js();
  
;

        echo "</div>";


    }

    public static function error(){
        
        



    }

    public static function info(){

        /**
         * Gets the phpinfo() function and 
         * strips all HTMl so that it is an 
         * array. This can be styled within
         * the debugger for later use.
         */

        // Source: https://www.php.net/manual/en/function.phpinfo.php#77692

        ob_start();
        phpinfo(-1);
    
        $s = ob_get_contents();
        ob_end_clean();
    
        $a = $mtc = array();
        if (preg_match_all('/<tr><td class="e">(.*?)<\/td><td class="v">(.*?)<\/td>(:?<td class="v">(.*?)<\/td>)?<\/tr>/',$s,$mtc,PREG_SET_ORDER)){
    
            foreach($mtc as $v){
                if($v[2] == '<i>no value</i>') continue;
                $a[$v[1]] = $v[2];
            }
        }
    
        return $a;
            
    }

}