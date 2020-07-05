<?php

function random2($n) {
    $str = '';
    $key = "ABCDEFGHIJKMLNOPQRSTUVWXYZabcdefghigkmlnopqrstuvwxyz0123456789";
    $key_len = strlen($key);

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, $key_len - 1);
        $str .= $key[$index]; 
    }
    return $str;
}

//echo random2(3);
