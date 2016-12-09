<?php
/**
* 为进程设置一个alarm闹钟信号
* 创建一个计时器，在指定的秒数后向进程发送一个SIGALRM信号。
* 每次对 pcntl_alarm()的调用都会取消之前设置的alarm信号。

* 配合declare一起使用

* require configure --enable-pcntl
*/
declare(ticks = 1); 
function a() 
{ 
    sleep(10); 
    echo "a finish \n"; 
} 
function b() 
{ 
    echo "Stop \n"; 
} 
function c() 
{ 
    usleep(100000); 
} 
 
function sig() 
{ 
    throw new Exception; 
} 
 
try 
{ 
    //设置一个闹钟信号为一秒钟执行一次 
    pcntl_alarm(1); 
    //安装闹钟信号，并绑定callback 
    pcntl_signal(SIGALRM, "sig"); 
    a(); 
    //取消闹钟信号 
    pcntl_alarm(0); 
} 
catch(Exception $e) 
{ 
    echo "timeout \n"; 
} 
b(); 
a(); 
b(); 
