<?php
/**
 * 同步阻塞客户端
 */
class Client {
    
    public $client;

    public function __construct() {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect() {
        if (!$this->client->connect("127.0.0.1", 9501, 1)) {
            echo "Connect faild.Error: $this->client->errCode. \n"; 
        }

        fwrite(STDOUT, "请输入消息：");

        $msg = trim(fgets(STDIN));

        $this->client->send($msg);

        sleep(1);

        $message = $this->client->recv();

        echo "Get Message From Server : {$message} \n";
    }
}

$client = new Client();
$client->connect();
