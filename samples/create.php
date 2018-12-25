<?php

/**
 * 创建队列
 */
$config = include 'config/config.php';

$instance = \DlyCli\Client::getInstance($config);

$attributes = [
    'delay_time' => 30,
    'list_name' => 'my_listen_queue',
    'config' => [
        'host'      => '127.0.0.1',
        'port'      => '6379',
        'database'  => '0',
        'prefix'    => 'online:',
    ]
];

$result = $instance->createQueue('ruesin', $attributes);

var_dump($result);
