<?php

class Test {
    public $index = 0;
}

class Server {
    
    public $serv;

    public $test;

    public function __construct() {
        $this->serv = new swoole_server('0.0.0.0', 9501);

        $this->serv->set(
            array(
                'work_num' => 8,
                'daemonize' => false,
                'max_request' => 1000,
                'dispatch_mode' => 2,
            )
        );

        $this->serv->on('Start', array($this, 'onStart'));

        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));
        $this->serv->on('WorkerStart', array($this, 'onWorkerStart'));

        $this->serv->start();
    }

    public function onStart($serv) {
       echo "Start \n"; 
    }

    public function onConnect($serv, $fd, $from_id) {
        echo "Client {$fd} connect({$from_id}). \n"; 
    }

    public function onReceive($serv, $fd, $from_id, $data) {
        echo "I get message from client {$fd} : {$data}. \n"; 
        echo "Continue handle worker \n";
    }

    public function onClose($serv, $fd, $from_id) {
        echo "Client {$fd} close connection. \n";
    }

    public function onWorkerStart($serv, $worker_id) {
        echo "workStart {$worker_id} \n";
        if($worker_id == 0) {
            $this->test = new Test();
            $this->test->index = 1;
            swoole_timer_tick(1000, array($this, 'onTick'), 'Hello'); 
        } 
    }

    public function onTick($timer_id, $params = null) {
        echo "Timer {$timer_id} runing \n";
        echo "Params : $params \n";
        
        echo "Timer running \n";
        echo "recv : {$params} \n";

        var_dump($this->test);

    }
}

$serv = new Server();
