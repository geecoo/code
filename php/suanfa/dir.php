<?php

function read_all($dir, $level) {
    if (!is_dir($dir)) return false;

    if ($handler = opendir($dir) ) {
        while (($file = readdir($handler)) !== false) {
            if ($file == '.' || $file == '..') {
                continue; 
            } 

            $temp_file = $dir . '/' . $file;
            if (is_dir($temp_file)) {
                read_all($temp_file, ++$level); 
            } else {
                echo str_repeat('-', $level) . $file . " \n"; 
            } 
        }  
    }

}

read_all("/data/www/code", 0);
