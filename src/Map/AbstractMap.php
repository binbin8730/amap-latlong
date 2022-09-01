<?php

namespace Encore\AmapLatlong\Map;

abstract class AbstractMap
{
    /**
     * Set to true to automatically get the current position from the browser
     * @var bool
     */
    protected $autoPosition = false;

    /**
     * @var string
     */
    protected $api;


    /**
     * @var string
     */
    protected $secret;



    /**
     * @var array
     */
    protected $params;

    /**
     * Tencent constructor.
     * @param $key
     */
    public function __construct($key = '', $secret = '')
    {
        if ($key && $secret) {
            // $this->api = sprintf($this->api, $key);
            $this->api = $key;
            $this->secret = $secret;
        }
    }

    /**
     * @return array
     */
    public function getAssets()
    {
        return [];
    }

    public function getParams($field = null)
    {
        if ($field) {
            return isset($this->params[$field]) ? $this->params[$field] : null;
        }
        return $this->params;
    }

    /**
     * Set true to automatically get the current position from the browser on page load
     * @param $bool
     * @return $this
     */
    public function setAutoPosition($bool)
    {
        $this->autoPosition = $bool;
        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param array $id
     * @param bool $autoPosition
     * @return string
     */
    abstract public function applyScript(array $id);
}
