<?php

require_once('RateGuard.php');


$redis = new Redis();
$redis->connect('127.0.0.1', 1234);
$redis->auth('your_password');

$RateGuard = new RateGuard($redis);

if(!$RateGuard->check(5)) die('TOO MANY REQUESTS FROM THE IP');

echo 'WOW!!!!!!!!'
?>
