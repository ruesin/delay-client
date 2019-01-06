<?php
/**
 * 发送消息
 */
$config = include dirname(__DIR__).'/config.php';

$instance = \DlyCli\Client::getInstance($config);
$queueName = 'ruesin_normal';

$result = $instance->sendMessage($queueName, 'This is delay active 5 seconds message.', 5);
$result = $instance->sendMessage($queueName, 'This is delay active 10 seconds message.', 10);
$result = $instance->sendMessage($queueName, 'This is delay active 20 seconds message.', 20);
$result = $instance->sendMessage($queueName, json_encode(['id' => 123, 'platform_id' => 95], JSON_UNESCAPED_UNICODE));

var_dump($result);
