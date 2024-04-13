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
        $key = $_SERVER['REMOTE_ADDR'];

        $store = function($current, $key_last='') use($key){
            try{
                $key_temp = $key.$key_last;
                $ttl = $this->redis->pttl($key_temp);
                $this->redis->set($key_temp, ++$current);
                $this->redis->pexpire($key_temp, (($ttl !== -2) ? $ttl : $this->duration));
                return true;
            }catch(RedisException|Exception $e){
                return false;
            }
        };
        
        $return = function($return = false) use($selected_db){
            $this->redis->select(($selected_db ?? 1));
            return $return;
        };
        
        $script = '@'.$_SERVER['SCRIPT_FILENAME'];
        $total = (int) $this->redis->get($key.$script);
        $master_limit = (int) $this->redis->get($key);
        
        return $return((($this->master_limit > $master_limit) && ($limit > $total) && $store($master_limit) && $store($total, $script)));
    }
}

?>
