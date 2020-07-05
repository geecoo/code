<?php

// 冒泡排序
function maopao($arr)
{
    $len = count ($arr);

    for ($i = 0; $i < $len; $i++)
    {
        for ($j = $len - 1; $j > $i; $j--) {
            if ($arr[$i] > $arr[$j]) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    } 
    print_r($arr);
}

//maopao([3, 5, 1, 2, 9, 8, 6]);

// 快速排序
function quickSort($arr) {
    //先判断是否需要继续进行
    if(($length = count($arr)) <= 1) {
        return $arr;
    }

    //选择第一个元素作为基准
    $base_num = $arr[0];
    //遍历除了标尺外的所有元素，按照大小关系放入两个数组内
    //初始化两个数组
    $left_array = array();  //小于基准的
    $right_array = array();  //大于基准的
    for($i=1; $i<$length; $i++) {
        if($base_num > $arr[$i]) {
            //放入左边数组
            $left_array[] = $arr[$i];
        } else {
            //放入右边
            $right_array[] = $arr[$i];
        }
    }
    //再分别对左边和右边的数组进行相同的排序处理方式递归调用这个函数
    $left_array = quickSort($left_array);
    $right_array = quickSort($right_array);
    //合并
 
    return array_merge($left_array, array($base_num), $right_array);
}

// print_r(quickSort ([5, 2, 4, 6,1, 9]));

// 二分查找算法（折半查找算法）

function binSearch($arr, $low, $high, $search)
{
    $mid = floor(($low + $high) / 2);

    if ($arr[$mid] == $search) {
        return $mid;
    } else if ($arr[$mid] < $search) {
        return binSearch($arr, $mid + 1, $high, $search);
    } else {
        return binSearch($arr, $low, $mid, $search);
    }

    return -1;
}

function binSearch2($arr, $search)
{
    $low = 0;
    $high = count($arr);

    while ($low < $high) {
        $mid = floor(($low + $high) / 2);

        if ($arr[$mid] == $search) {
            return $mid;
        } else if ($arr[$mid] < $search) {
            $low = $mid + 1;
        } else {
            $high = $mid;
        }
    }
    return -1;
}
// print_r(binSearch([1, 3, 5, 9], 0, 3, 9));

//洗牌
$card_num = 54;//牌数
function wash_card($card_num){
    $cards = $tmp = array();
    for($i = 0;$i < $card_num;$i++){
        $tmp[$i] = $i;
    }

    for($i = 0;$i < $card_num;$i++){
        $index = rand(0,$card_num-$i-1);
        $cards[$i] = $tmp[$index];
        unset($tmp[$index]);
        $tmp = array_values($tmp);
    }

    return $cards;
}

function test(){
 $a=1;
 $b=&$a;
 echo (++$a)+(++$a);
}
test();
