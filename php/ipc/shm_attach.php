<?php

// Get the file token key
$key = ftok(__DIR__, 'a');

// 创建一个共享内存
$shm_id = shm_attach($key, 1024, 777); // resource type
if ($shm_id === false) {
    die('Unable to create the shared memory segment');
}

#设置一个值
# int $variable_key  key必须是整形
shm_put_var($shm_id, 1, 'linux');

#获取一个值
$value = shm_get_var($shm_id,  1);
var_dump($value);

#检测一个key是否存在
echo "Check key is exist: ";
var_dump(shm_has_var($shm_id,  12));

#删除一个key
//shm_remove_var($shm_id, 111);
#从系统中移除
shm_remove($shm_id);

#关闭和共享内存的连接
shm_detach($shm_id);
