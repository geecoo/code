<?php

class IdWorker
{
    // 开始时间
    private $twepoch = 1420041600000;

    /**
     * 机器表示占的二进制位数
     */
    private $workerIdBits = 5;

    /**
     * 数据中心表示占的二进制位数
     */
    private $datacenterIdBits = 5;


    /**
     * 自增序列位数
     */
    private $sequenceBits = 12;

    /*
     * 最大机器数量 
     * 31
     */
    protected $maxWorkerId;

    /**
     * 最大数据中心数量 
     * 31
     */
    protected $maxDatacenterId;

    /**
     * 机器左位移量 
     * 12 
     */
    protected $workerIdShift;

    /**
     * 数据中心左位移量 
     * 17
     */
    protected $datacenterIdShift;

    /**
     * 时间戳左偏移量 
     * 22
     */
    protected $timestampLeftShift;

    /**
     * 自增序列最大生产数
     * 4095
     */
    protected $sequenceMask;

    // 机器编码
    private $workerId;

    // 数据中心编码
    private $datacenterId;

    // 自增序列值
    static $sequence = 0;

    /**
     * 上次生成的时间戳
     */
    static $lastTimestamp = -1;

    public function __construct($workerId, $datacenterId) 
    {
        // 机器ID范围计算 31
        $this->maxWorkerId = -1 ^ (-1 << $this->workerIdBits); 

        // 最大的数据中心ID 31
        $this->maxDatacenterId = -1 ^ (-1 << $this->datacenterIdBits);

        // 机器ID偏移位数 12
        $this->workerIdShift = $this->sequenceBits;

        // 数据中心左移位 17 
        $this->datacenterIdShift = $this->sequenceBits + $this->workerIdBits;  

        if ($workerId > $this->maxWorkerId || $workerId < 0) {  
            throw new Exception('worker id cannot be greater than ' . $this->maxWorkerId);
        }

        if ($datacenterId > $this->maxDatacenterId || $datacenterId < 0) {
            throw new Exception('datacenter id cannot be greater than ' . $this->maxDatacenterId);
        }

        $this->workerId = $workerId;
        $this->datacenterId = $datacenterId;
    }

    public function nextId()
    {
        $timestamp = $this->timeGen(); 

        if ($timestamp < self :: $lastTimestamp) { 
            throw new Exception('Clock moved backwards.'); 
        }

        if (self :: $lastTimestamp == $timestamp) {
            self :: $sequence = (self :: $sequence + 1) & $this->sequenceMask; 

            if (self :: $sequence == 0) {
                $timestamp = $this->tilNextMillis(self :: $lastTimestamp); 
            }
        } else {
             self :: $sequence = 0;
        } 

        self :: $lastTimestamp = $timestamp;  
        return (($timestamp - $this->twepoch) << $this->timestampLeftShift) | ($this->datacenterId << $this->datacenterIdShift) | ($this->workerId << $this->workerIdShift) | self :: $sequence;
    }

    /**
     * 等待下一毫秒
     */
    protected function tilNextMillis($lastTimestamp) 
    {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }

    protected function timeGen()
    {
        $timestamp = (float)sprintf("%.0f", microtime(true) * 1000);
        return  $timestamp;
    }
}

$worker = new IdWorker(2, 1);
for($i = 0; $i < 10; $i++) {
    echo $worker->nextId();
    echo PHP_EOL;
}
