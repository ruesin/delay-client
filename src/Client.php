<?php
namespace DlyCli;

/**
 * Class Client
 * @package Huox\Delay\Client
 */
class Client
{
    private static $instance = [];

    /**
     * @var Request
     */
    private $request = null;

    private function __clone(){}

    private function __construct($config)
    {
        $this->request = new Request(new Config($config));
    }

    /**
     * 获取配置
     * @throws \Exception
     */
    private static function getConfig($config)
    {
        if (!isset($config['access_id'])) {
            throw new \Exception('[access_id] Incomplete configuration!');
        }

        if (!isset($config['access_key'])) {
            throw new \Exception('[access_key] Incomplete configuration!');
        }

        if (!isset($config['end_point'])) {
            throw new \Exception('[end_point] Incomplete configuration!');
        }

        ksort($config);
        return $config;
    }

    /**
     * 获取单例
     *
     * @param array $config 配置
     * @return bool|self
     */
    public static function getInstance($config)
    {
        try {
            $config = self::getConfig($config);
            $hash = md5(json_encode($config, JSON_UNESCAPED_UNICODE));
            if (! isset(self::$instance[$hash])) {
                self::$instance[$hash] = new self($config);
            }
            return self::$instance[$hash];
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 创建队列
     *
     * @param string $queueName 队列名称
     * @param array $information 队列配置信息
     * [
     *     'delay_time' => 30,
     *     'list_name' => 'my_listen_queue',
     *     'config' => [
     *         'host'      => '127.0.0.1',
     *         'port'      => '6379',
     *         'database'  => '0',
     *         'prefix'    => 'online:',
     *     ]
     * ]
     * @return array|bool
     */
    public function createQueue($queueName, $information = [])
    {
        try {
            $this->request->setAction('create');
            return $this->request->send($queueName, $information);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 删除队列
     * @param string $queueName 队列名称
     * @return array|bool
     */
    public function dropQueue($queueName)
    {
        try {
            $this->request->setAction('drop');
            return $this->request->send($queueName);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 发送消息到指定的消息队列
     *
     * @param string $queueName 队列名称
     * @param string $messageBody 消息体
     * @param int $DelaySeconds 延时时间（秒）
     * 'data' => [
     *     'delay_time' => 10000,
     *     'message' => 'This is my first message.'
     * ]
     * @return array|bool
     */
    public function sendMessage($queueName, string $messageBody, $DelaySeconds = 0)
    {
        try {
            $this->request->setAction('add');
            return $this->request->send($queueName,['message' => $messageBody, 'delay_time' => $DelaySeconds]);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取消息
     * @param string $queueName 队列名称
     * @return array|bool
     */
    public function getMessage($queueName)
    {
        try {
            $this->request->setAction('get');
            return $this->request->send($queueName);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 删除消息
     * @param string $queueName 队列名称
     * @param string $messageId 消息唯一标识
     * @return array|bool
     */
    public function deleteMessage($queueName, $messageId)
    {
        try {
            $this->request->setAction('get');
            return $this->request->send($queueName, ['messageId' => $messageId]);
        } catch (\Exception $e) {
            return false;
        }
    }
}


