<?php
/**
 * 结合Ticks来实现PHP的消息通信
 */

$mesg_key = ftok(__FILE__, "m");

//创建或连接到消息队列
$mesg_id = msg_get_queue($mesg_key, 0666);

function fetchMessage($mesg_id)
{
    if (!is_resource($mesg_id)) {
        print_r("Message queue is not ready. \n"); 
    }

    // 参数 $desiredmsgtype ( 1 ) 是和msg_send里的msgtype对应的
    // if $desiredmsgtype < msgtype, 则接收 > $desiredmsgtype的所有消息类型
    if (msg_receive($mesg_id, 1, $mesg_type, 1024, $mesg, true, MSG_IPC_NOWAIT)) {
        print_r("Receive Message: $mesg \n"); 
    }
}

register_tick_function('fetchMessage', $mesg_id);

declare(ticks=1) {
    $i = 0;
    while (++$i < 100) {
        if ($i % 5 == 0) {
            msg_send($mesg_id, 1, "Hi, Now index is:" . $i);
        } else if ($i % 6 == 0) {
            msg_send($mesg_id, 2, "Oh, Now index is:" . $i);
        }
    }
}
msg_remove_queue($mesg_id);
