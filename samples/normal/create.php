<?php

/**
 * 创建队列
 */
$config = include dirname(__DIR__).'/config.php';

$instance = \DlyCli\Client::getInstance($config);

$queueName = 'ruesin_normal';

$attributes = [
    'delay_time' => 30,
    'hide_time'  => 50
];

$result = $instance->createQueue($queueName, $attributes);
var_dump($result);
