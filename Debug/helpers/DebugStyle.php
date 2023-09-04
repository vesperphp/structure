<?php

/**
 * The Debugging package within Vesper. Will be
 * put to good use!
 */

namespace App\Debug;

class DebugStyle{


    public static function css(){
        ?>

        <style>

            .vesper-debug{
                font-family: Rubik, Arial, Helvetica, sans-serif;
                color: Black;
                padding: 1.7em;
                background-color: #9CDFEF;
                margin-top: 3em;
                padding-top: 1px;
                
            }

            .vesper-debug pre{
                background-color: White;
                padding: 1em;
                color: Blue;
                border-top: 5px solid Black;
            }

            .vesper-debug div.debug-table{
                border-top: 5px solid Black;
            }

            .vesper-debug div.debug-row{
                display: flex;
                padding: .3em 2em;
                background-color: white;
            }

            .vesper-debug div.debug-row:hover{
                background-color: #efefef;
            }

            .vesper-debug div.debug-col{
                padding: 0;
                min-width: 15%;
                text-wrap: wrap;
                padding-right: 2em;
            }

            .vesper-debug div.debug-col pre{
                padding: 0 !important;
                border: 0;
                background: transparent;
                text-wrap: wrap;
            }

            .vesper-debug div.debug-col strong{
                color: black;
            }

            .vesper-debug div.debug-var{
                text-wrap: wrap;
                background-color: blue;
                color: white;
                padding: 2em;
            }

            .vesper-debug .debug-subtitle{
                font-size: 2em;
                color: blue;
    
            }

            .vesper-debug .debug-timestamp{
                font-size: .7em;
                color: black;
                margin-top: -2em;
            }

            .vesper-debug button.debug-toggle-button{
                display: block;
                border: 1px solid blue;
                margin: .5em 0;
                padding: 1em;
                color: blue;
                background-color: transparent;
                width: 100%;
                text-align: left;
            }

            .vesper-debug .hidden{
                display: none;
            }

            .vesper-debug .block{
                display: none;
            }

        </style>


        <?php
    }

    public static function js(){
        ?>

        <script>

        function debugToggle(DBID) {
            var element = document.getElementById(DBID);
            element.classList.toggle("visible");
            element.classList.toggle("hidden");
            }

        </script>

        <?php
    }


    public static function table($a){
        
        if(!is_array($a)){

            echo "<div class='debug-var'><pre>";
            var_dump($a);
            echo "</strong></pre></div>";
            

        }else{
   
            echo "<div class='debug-table'>";

            foreach($a as $key => $val){

                echo "<div class='debug-row'>";

                    echo "<div class='debug-col'><pre><strong>";
                    echo var_dump($key);
                    echo "</strong></pre></div>";

                    echo "<div class='debug-col'><pre>";
                    echo var_dump($val);
                    echo "</pre></div>";
                
                echo "</div>";

            }
        
            echo "</div>";
        }
        
    }

}