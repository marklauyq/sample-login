<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 17/10/2017
 * Time: 8:51 PM
 *
 * This class is used to manage the User transaction log
 */

namespace App;

use Redis;

class RedisLog
{
    /**
     * @var
     */
    private $id;
    /**
     * @var array
     */
    private $logs;

    /**
     * RedisLog constructor.
     * Initialize using the user id
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $key = 'user:'.$this->id;
        $this->logs = Redis::hgetall($key);
        if(empty($this->logs)){
            $this->logs = [];
        }
    }

    /**
     * push to the logs
     * @param array $dataset
     */
    public function push(Array $dataset){
        array_push($this->logs, json_encode($dataset));
    }

    /**
     * return all the logs
     * @return mixed
     */
    public function getLogs(){
        $logs = [];
        foreach($this->logs as $log){
            $logs[] = json_decode($log, true);
        }
        return $logs;
    }

    /**
     * save the current data into redis
     * @param $id
     */
    public function store(){
        $key = 'user:'.$this->id;
        try {
            Redis::hmset($key, $this->logs);
        } catch (\Exception $e){
            dd([$key, $this->logs]);
        }
    }

    /**
     * get the key for this user
     * @return string
     */
    public function getKey(){
        return 'user:' . $this->id;
    }
}