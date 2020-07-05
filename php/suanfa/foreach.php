<?php

$a=[1,2,3]; 
foreach ($a as &$v){} 

print_r($v);die;
foreach ($a as $v){
    echo $v;
} 
print_r($a); 
echo "\n" . $v;
