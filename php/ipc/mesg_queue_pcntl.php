<?php
/**
 * 父子进程使用消息队列通信
 *
 */

$mesg_key = ftok(__FILE__, "m");

$mesg_id = msg_get_queue($mesg_key, 0666);

$pid = pcntl_fork();

if ($pid == -1) {
    die("Couldn't fork process. \n");
} else if ($pid) {
    // parent
    // protect against zombie children
    pcntl_wait($status);

    $queue_status = msg_stat_queue($mesg_id);
    echo 'Messages in the queue: ' . $queue_status['msg_qnum']."\n";
    if (msg_receive($mesg_id, 1, $message_type, 1024, $message, true, MSG_IPC_NOWAIT)) {
        echo $message . "\n"; 
    }
} else {
    // children
    $sid = posix_getpid();
    if (msg_send($mesg_id, 1, "the data from process $sid. \n")) {
        echo "children process send message success. \n";
    }
}
