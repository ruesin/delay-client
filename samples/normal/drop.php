<?php
/**
 * 删除队列
 */
$config = include dirname(__DIR__).'/config.php';

$instance = \DlyCli\Client::getInstance($config);
$queueName = 'ruesin_normal';

$result = $instance->dropQueue($queueName);

var_dump($result);
