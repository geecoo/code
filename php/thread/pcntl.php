<?php

class WebServer
{
    private $list;

    public function __construct()
    {
        $this->list = [];
    }

    public function worker($request)
    {
        $pid = pcntl_fork();

        if ($pid == -1) {
            return false;
        }

        if ($pid > 0) {
            // we are the parent
            return $pid;
        }

        if ($pid == 0) {
            // we are the child
            $time = $request[0];
            $method = $request[1];

            $start = microtime(true);

            echo getmypid()."\t start ".$method."\tat".$start.PHP_EOL;
            //sleep($time);
            $c = file_get_contents($method);
           // echo getmypid() ."\n";
            $end = microtime(true);
            $cost = $end-$start;
            echo getmypid()."\t stop \t".$method."\tat:".$end."\tcost:".$cost.PHP_EOL;
            exit(0);
        }
    }

    public function master($requests)
    {
        $start = microtime(true);

        echo "All request handle start at ".$start.PHP_EOL;

        pcntl_signal(SIGCHLD, SIG_IGN); //如果父进程不关心子进程什么时候结束,子进程结束后，内核会回收。

        foreach ($requests as $request) {
            $pid = $this->worker($request);
            if (!$pid) {
                echo 'handle fail!'.PHP_EOL;
                return;
            }
            array_push($this->list,$pid);
        }

        while (count($this->list)>0) {
            foreach ($this->list as $k=>$pid) {
                //Protect against Zombie children
                $res = pcntl_waitpid($pid,$status,WNOHANG);
                if($res == -1 || $res > 0){
                    unset($this->list[$k]);
                }
            }
            usleep(100);
        }

        $end = microtime(true);
        $cost = $end - $start;
        echo "All request handle stop at ".$end."\t cost:".$cost.PHP_EOL;
    }
}

$requests = [
  [1,'http://www.sina.com'],
  [2,'http://www.sina.com'],
  [3,'http://www.sina.com'],
  [4,'http://www.sina.com'],
  [5,'http://www.sina.com'],
  [6,'http://www.sina.com']
];

echo "多进程测试：".PHP_EOL;

$server = new WebServer();
$server->master($requests);

die;
echo PHP_EOL."单进程测试：".PHP_EOL;
$start = microtime(true);
for($i=0;$i<6;$i++){
    $c = file_get_contents("http://www.sina.com");
}
$end = microtime(true);
$cost = $end - $start;
echo "All request handle stop at ".$end."\t cost:".$cost.PHP_EOL;
