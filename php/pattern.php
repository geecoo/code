<?php

// pattern script
$pattern = '/<script[^>]*?>.*?</script>/si';

// pattern html
$pattern1= '/<("[^"]*"|\'[^\']\*\'|[^>"\'])*>/';

//pattern email
//preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/',$email);

$curTime = time();
$day = date('j', time());
echo date('Y-m-d', strtotime("- {$day} days", time()));
echo PHP_EOL;

function isemail($email) 
{
    return strlen($email) > 6 && strlen($email) <= 32 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
}

// 三位为一组增加,
function addDou() {
    $num = '12345678912345678999';
    //return  number_format($num, 2, '.', ',');
    return preg_replace('/\B(?=(\d{3})+(?!\d))/', ',', $num);
}
print_r(addDou());

