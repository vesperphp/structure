<?php

namespace App\Front;


/**
 * Compiler is the engine
 * behind the View. Grabbing
 * the templates and turning them
 * into cached php layouts.
 */

class ViewCompiler extends View{

    private $source;
    static $blocks = array();


    public function __construct(string $source){

        $this->source = $source;   

    }

    /**
     * Run the compiler,
     * this changes the template file
     * to a PHp file with everything 
     * in the right place..
     * ..if you are lucky.
     */
    
    public static function run(string $cached){

            /**
             * Combine all files into one
             * source string. This is with
             * the includes and extends.
             */

            $source = self::fetch($cached);

            /**
             * Set up an compiler instance
             * to work with the source var.
             */
            
            $compile = new ViewCompiler($source);

            /**
             * Compile all the global variables
             * and other helper tags
             */
            
            //$compile->glob();
            //$compile->route();
            //$compile->hook();
            //$compile->flash();
    
            /**
             * Shuffle HTML around
             * and create one neat file.
             */

            $compile->blocks();
            $compile->yield();
    
            /**
             * Process all the echo's and 
             * escaped echo's.
             */

            $compile->escaped();
            $compile->echo();
    
            /**
             * Cleanup and return
             * the compiled file
             * contents:
             */

            $compile->tags();
            return $compile->dump(); 

    }

    /**
     * Fetch files and fix the  right includes. This also
     * combines files into singular templates.
     */

    public static function fetch(string $cached){


        /**
         * Store the contents of the source file 
         * within a variable:
         */

        $source = file_get_contents(ROOTPATH.'/App/Views/'.$cached.".html");
        
        /**
         * Search for all the extends and includes
         * within that source. Store that array 
         * in $embeds.
         */

        preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $source, $embeds, PREG_SET_ORDER);
        
        /**
         * Work down the files, adding includes
         * and extensions untill all files are
         * combined to a single source.
         */

        foreach ($embeds as $embed) {
            $source = str_replace($embed[0], self::fetch($embed[2]), $source);
        }

        /**
         * After that, clean up.
         */

        $source = preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $source);
        
        /**
         * Return the source with all 
         * the extensions and includes
         * in them.
         */

        return $source;

    }

    /**
     * Return the source variable
     * to the method
     */

    public function dump() {

        return $this->source;

    }

    /**
     * Turn a {{ $variable }} into a
     * echo for displaying.
     */

    public function echo() {

        $this->source = preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $this->source);

    }

    /**
     * If you want to echo safely
     * use an extra {{{ $bracket }}}
     */

    public function escaped() {

        $this->source = preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $this->source);

    }


    /**
     * Clean up left over brackets and
     * exchange them for php tags. Now the
     * foreaches and if/elses also work.
     */

    public function tags() {

        $this->source = preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $this->source);
        
    }

    /**
     * Prepare all the blocks
     * and put them in an
     * array for use by yield.
     */

    public function blocks() {

        /**
         * Pull all the available blocks
         * from the source.
         */

        preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $this->source, $matches, PREG_SET_ORDER);


        /**
         * Handle them one by one 
         * with foreach.
         */

        foreach ($matches as $value) {
            if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';

            /**
             * Check if the block is an extention (wrapper) or 
             * a regular block.
             */

            if (strpos($value[2], '@parent') === false) {

                /**
                 * This is a regular block.
                 */

                self::$blocks[$value[1]] = $value[2];
            } else {

                /** 
                 * This is an extention wrapper because
                 * it has the @parent variable in it.
                 * The @parent will load the code from
                 * the parent page. Nice as a html
                 * wrapper for your content.
                 */

                self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
            }

            /**
             * Clean up the output.
             */

            $this->source = str_replace($value[0], '', $this->source);
        }
    }

    /**
     * Put all the blocks in the right
     * places and combine with source.
     */

    public function yield() {

        /** 
         * Search for blocks in the source
         * and replace the yield tags
         * with those said blocks.
         */

        foreach(self::$blocks as $block => $value) {

            $this->source = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $this->source);

        }

        $this->source = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $this->source);

    }

    /**
     * Prepare global variables
     */
/*
    public function glob() {

        $this->source = preg_replace('~\{% @ \s*(.+?)\s*\ %}~is', '<?php Glob::al("$1",true); ?>', $this->source);
        
    }*/

    /**
     * Prepare route information
     */
/*
    public function route() {

        $this->source = preg_replace('~\{% route \s*(.+?)\s*\ %}~is', '<?php echo Config::get("site/uri")."/$1"; // route ?>', $this->source);

        
    }*/

    /**
     * Prepare flash information
     */
/*
    public function flash() {

        $this->source = preg_replace('~\{% flash \s*(.+?)\s*\ %}~is', '<?php Flash::front("$1"); // flash ?>', $this->source);

        
    }*/

    /**
     * Load all the hooked assets
     */
/*
    public function hook() {

        $this->source = preg_replace('~\{% hook \s*(.+?)\s*\ %}~is', '<?php Hook::frontier("$1"); // hooks ?>', $this->source);
        
    }*/

}