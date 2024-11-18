<?php

class Request
{
    private $params;

    public function __construct()
    {
        $this->params = [];
    }


    public function setParams($params)
    {
        $this->params = $params;
    }


    public function getParams($key = null)
    {
        if ($key === null) {
            return $this->params;
        }

        return $this->params[$key] ?? null;
    }
}
