<?php

/**
* $n 猴子总量
* $m 第$m只猴子踢出去
* 队列出队入队
*/
function king($n, $m)
{
    $monkeys = range(1, $n);
    
    $i = 0;

    while (count($monkeys) > 1) {
        if (($i + 1) % $m == 0) {
            unset ($monkeys[$i]);
        } else {
            array_push($monkeys, $monkeys[$i]);
            unset ($monkeys[$i]);
        }

        $i++;
    }

    return current($monkeys);
}

//echo king(6, 2);
