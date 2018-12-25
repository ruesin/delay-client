<?php
/**
 * 删除队列
 */
$config = include 'config/config.php';

$instance = \DlyCli\Client::getInstance($config);

$result = $instance->dropQueue('ruesin');

var_dump($result);
