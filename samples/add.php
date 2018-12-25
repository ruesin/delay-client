<?php
/**
 * 发送消息
 */
$config = include 'config/config.php';

$instance = \DlyCli\Client::getInstance($config);

$result = $instance->sendMessage('ruesin', 'This is My first message. Delay active 5 seconds.', 5);

$instance->sendMessage('ruesin', json_encode(['id'=>123,'platform_id'=>95]), JSON_UNESCAPED_UNICODE);

var_dump($result);
