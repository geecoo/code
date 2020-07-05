<?php
/**
* 有一母牛，到4岁可生育，每年一头，所生均是一样的母牛，到15岁绝育，不再能生，20岁死亡，问n年后有多少头牛

递归
静态变量
*/
function niu($n)
{
    static $total = 1;
    
    for ($i = 1; $i <= $n; $i++)
    {
        if ($i >= 4 && $i < 15) {
            $total++;
            niu($n - 1);
        } else if ($i == 20) {
           $total--; 
        } 
    }

    return $total;
}

echo niu(8);
