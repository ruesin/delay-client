<?php

/**
 * 创建队列
 */
$config = include dirname(__DIR__).'/config.php';

$instance = \DlyCli\Client::getInstance($config);
$queueName = 'ruesin_custom';

$attributes = [
    'delay_time' => 30,
    'list_name' => 'my_custom_queue',
    'config' => [
        'host'      => '127.0.0.1',
        'port'      => '6379',
        'database'  => '0',
        'prefix'    => 'custom_online:',
    ]
];

$result = $instance->createQueue($queueName, $attributes);

var_dump($result);
