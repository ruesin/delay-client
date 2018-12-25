<?php
namespace DlyCli;

class Request
{
    private $action = '';

    private $version = '1.0.0';

    /**
     *
     * @var Config
     */
    private $config = null;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function send($queueName, $data = [])
    {
        $request = [
            'action'     => $this->action,
            'queue_name' => $this->getQueueName($queueName),
            'data'       => json_encode($data, JSON_UNESCAPED_UNICODE)
        ];

        $request['time'] = time();
        $request['access_id'] = $this->config->getAccessId();

        $request['sign'] = $this->sign($request);

        $result = $this->sendRequest($request);

        $this->clear();

        return $result;
    }

    private function sendRequest($data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->config->getEndPoint());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36',
            'Delay-Client:'.$this->version
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        //$info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $this->response($response);
    }

    private function response($response)
    {
        $result = [
            'status'  => '0',
            'message' => 'Unknown error!',
            'data'    => []
        ];
        if (!$response) {
            return $result;
        }

        $array = json_decode($response, true);
        if (!$array) {
            $result['message'] = $response;
            return $result;
        }

        if (!isset($array['status'])) {
            return $result;
        }

        $result['status']  = $array['status'];

        if (isset($array['message'])) {
            $result['message'] = $array['message'];
        }

        if (isset($array['data'])) {
            $result['data'] = $array['data'];
        }

        return $result;
    }

    /**
     * 签名
     * @param array $request
     * @return string
     */
    private function sign(array $request)
    {
        $time = $request['time'];
        unset($request['time'], $request['access_id']);

        foreach ($request as $key => $val) {
            if (is_array($val)) {
                ksort($val);
                $request[$key] = json_encode($val, JSON_UNESCAPED_UNICODE);
            } else {
                $request[$key] = $val.'';
            }
        }

        ksort($request);

        return md5(date('YmdHis', $time) . substr(md5(json_encode($request, JSON_UNESCAPED_UNICODE) . $time), 8, 16) . $this->config->getAccessKey());
    }

    private function getQueueName($queueName)
    {
        return $this->config->getPrefix().$queueName;
    }

    private function clear()
    {
        $this->action = '';
    }
}


