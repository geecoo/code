<?php
/**
在terminal, 可以使用
ipcs  查看所有IPC数据(Sem, SharedMemory, MesgQueue)
ipcrm 删除申请的内存块
ipcrm -m id

场景：
在内存里记录共享数据
缓存
计数
自增ID
*/

function memoryUsage() {
    printf("%s : %s \n", date("Y-m-d H:i:s"), memory_get_usage());
}

register_tick_function('memoryUsage');

declare(ticks=1) {
    $shm_key = ftok(__FILE__, 's');
    //创建大小为100 Bytes 的内存块
    $shm_id = shmop_open($shm_key, 'c', 0644, 100);
}

printf("Size of Shared Memory is: %s \n", shmop_size($shm_id));

// 读取范围必须在申请的内存范围内，否则会出错
$shared_text= shmop_read($shm_id, 0, 100);

$shared_array = null;

// 序列化的字符串
if (!empty($shared_text)) {
    $shared_text = trim($shared_text);
    $shared_array = unserialize($shared_text); 
}

if (!empty($shared_array)) {
    var_dump($shared_array);
    $shared_array['id'] += 1;
} else {
    $shared_array = array('id' => 1);
}

//$output_str = "\$shared_array=" . var_export($shared_array, true) . ";";
$output_str = serialize($shared_array);
$output_str = str_pad($output_str, 1022, " ", STR_PAD_RIGHT);
//写入的长度不能超过shmop_open的长度
shmop_write($shm_id, $output_str, 0);

#删除 只是做一个删除标志位，同时不在允许新的进程进程读取，当在没有任何进程读取时系统会自动删除
//shmop_delete($shm_id);

// close shared memory block
// shmop_close($shm_id);

