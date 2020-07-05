<?php
/**
 * 服务端， 接受客户端连接并发送数据给客户端
 */
$socket = stream_socket_server("udp://127.0.0.1:1113", $errno, $errstr, STREAM_SERVER_BIND);
if (!$socket) {
    die("$errstr ($errno)");
}

do {
    // 不能使用 stream_socket_accept函数
    $pkt = stream_socket_recvfrom($socket, 1, 0, $peer);
    echo "$peer\n"; // $peer 客户端连接地址
    stream_socket_sendto($socket, date("D M j H:i:s Y\r\n"), 0, $peer);
} while ($pkt !== false);

