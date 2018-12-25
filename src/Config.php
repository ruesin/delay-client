<?php
namespace DlyCli;

class Config
{
    private $prefix = '';
    private $access_id = '';
    private $access_key = '';
    private $end_point = '';

    public function __construct($config)
    {
        $this->access_id = $config['access_id'];

        $this->access_key = $config['access_key'];

        $this->end_point = $config['end_point'];

        if (isset($config['prefix'])) {
            $this->prefix = $config['prefix'];
        }
    }

    public function getAccessId()
    {
        return $this->access_id;
    }

    public function getAccessKey()
    {
        return $this->access_key;
    }

    public function getEndPoint()
    {
        return $this->end_point;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }
}


