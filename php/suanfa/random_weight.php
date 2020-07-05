<?php
// 根据权重随机抽奖算法
$data = array(
    array('id' => 1, 'name' => 'ZhangSan', 'weight' => 5),
    array('id' => 2, 'name' => 'LiSi', 'weight' => 10),
    array('id' => 3, 'name' => 'WangWu', 'weight' => 15),
);

// 放大法， 占用空间大
function random1($arr) {
    $weightSum = 0;

    //初始化对象池、抽奖池
    $pool = array();
    
    foreach ($arr as $v) {
        // 计算总权重
        $weightSum += $v['weight']; 

        for ($i = 0; $i < $v['weight']; $i++) {
            $pool[] = $v; 
        }
    }
    shuffle($pool);
    $index = rand(0, $weightSum);
    return $pool[$index]['name'];
}

// 区间法
function random2($arr) {
     $weightSum = 0;

     foreach ($arr as $k => $v) {
        // 计算总权重
        $weightSum += $v['weight']; 
        $arr[$k]['range'] = $weightSum;
    }
     $index = rand(0, $weightSum);

     foreach ($arr as $k => $v) {
         if ($v['range'] > $index) {
            break; 
         }  
     }
     return $v['name'];
}

function random3($arr) {
     $weightSum = 0;

     foreach ($arr as $k => $v) {
        // 计算总权重
        $weightSum += $v['weight']; 
        //$arr[$k]['range'] = $weightSum;
    }
     $index = rand(0, $weightSum);

     foreach ($arr as $k => $v) {
         if ($v['weight'] > $index) {
            break; 
         }  
         $index -= $v['weight'];
     }
     return $v['name'];
}
echo random3($data);
