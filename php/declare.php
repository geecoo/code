<?php
/**
每执行N条低级语句，就会触发tick_handler函数
场景:
性能分析
分析代码
*
* 低级语句(low-level statement)
*/

function tick_handler() 
{
    echo "tick_handler() called. \n";    
}

register_tick_function('tick_handler', true);

declare(ticks=1); // 1

$a = 1;   // 1
//if ($a > 0) {
//    $a += 2; //  1 
    echo $a . "\n";  // 1
//}   // 1
