<?php

namespace SMSPilot;

use SMSPilot\Exception\SMSPilotException;

class Processing
{

    private $url;
    private $useIncludePath;
    private $context;
    /** @var string $response */
    private $response;

    /**
     * @param string $url
     * @param bool $useIncludePath
     * @param null|resource $context
     */
    public function __construct($url, $useIncludePath = false, $context = null)
    {
        $this->url = $url;
        $this->useIncludePath = $useIncludePath;
        $this->context = $context;
    }

    /**
     * @return Processing
     */
    public function sendRequest()
    {
        $this->response = file_get_contents($this->url, $this->useIncludePath, $this->context);
        return $this;
    }

    /**
     * @return array
     * @throws SMSPilotException
     */
    public function getRequestResult()
    {
        $response = json_decode($this->response, true);
        if (!isset($response['error'])) {
            return $response;
        }
        throw new SMSPilotException($response['error']['code']);
    }
}