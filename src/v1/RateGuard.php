<?php

class RateGuard {
    private $redis = null;
    private $master_limit = 30;
    private $database_index = 5;
    private $duration = 10000;
    
    public function __construct($redis){
        $this->redis = $redis;
    }
    
    public function check($limit = 30){
        $selected_db = $this->redis->getDbNum();
        $this->redis->select($this->database_index);
        $key = $_SERVER['REMOTE_ADDR'].'@'.$_SERVER['SCRIPT_FILENAME'];

        $store = function($current) use($key){
            try{
                $ttl = $this->redis->pttl($key);
                $this->redis->set($key, ++$current);
                $this->redis->pexpire($key, (($ttl !== -2) ? $ttl : $this->duration));
                return true;
            }catch(RedisException|Exception $e){
                return false;
            }
        };
        
        $return = function($return = false) use($selected_db){
            $this->redis->select(($selected_db ?? 1));
            return $return;
        };
        
        $total = $this->redis->get($key);
        $total = !$total ? 0 : $total;
        return $return((($this->master_limit > $total) && ($limit > $total) && $store($total)));
    }
}

?>
