<?php
/**
 * 删除消息
 */
$config = include dirname(__DIR__).'/config.php';

$instance = \DlyCli\Client::getInstance($config);
$queueName = 'ruesin_custom';

$message_id = $argv[1];

$result = $instance->deleteMessage($queueName, $message_id);

var_dump($result);
