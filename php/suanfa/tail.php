<?php

function tail1($fp, $n) {

    $line = $n;
    $pos = -2;

    while ($line > 0) {
        $t = "";
        while ($t != "\n") {
            fseek($fp, $pos, SEEK_END); 
            $t = fgetc($fp); 
            $pos--;
        }
        echo fgets($fp);
        $line--;
    } 
}

function tail2($fp, $n) {
    $chunk = 40;
    $chunk_data = '';

    $total = sprintf("%u", filesize(__FILE__)); 
    $size = ($total - $chunk > $chunk) ? $chunk : $total - $chunk;  

    for ($pos = 0; $pos < $total; $pos += $chunk) {
        fseek($fp, -$pos, SEEK_END);
        $chunk_data = fread($fp, $chunk) . $chunk_data;

        if (substr_count($chunk_data, "\n") > $n + 1) {
            echo $chunk_data; 
            //preg_match("!(.*?\r\n)$!", $chunk_data, $match);
            //print_r($match);
            break;
        }
    }
}

function tail3($fp, $n) {
    $base = 5;
    $data = [];
    $pos = $n + 1;

    while (count($data) <= $n) {
        fseek($fp, -$pos, SEEK_END); 
        $data = [];
        while(!feof($fp)) {
            array_unshift($data, fgets($fp)); 
        }
        $pos *= $base;
    } 
    print_r($data);
    //print_r(array_slice($data, 0, $n));
    //echo implode("\n", array_slice($data, 0, $n));
}
$file = __FILE__;
$fp = fopen($file, 'r');
tail3($fp, 2);
