<?php
/**
 * 获取消息
 */
$config = include dirname(__DIR__).'/config.php';

$instance = \DlyCli\Client::getInstance($config);
$queueName = 'ruesin_normal';

$result = $instance->getMessage($queueName);

var_dump($result);
