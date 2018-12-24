<?php

namespace SMSPilot;

use SMSPilot\Exception\SMSPilotException;

class Processing
{

    private $url;
    /** @var string $response */
    private $response;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return Processing
     */
    public function sendRequest()
    {
        $this->response = file_get_contents($this->url);
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
        throw new SMSPilotException(json_encode([
            'code' => $response['error'],
            'reason' => [
                'en' => $response['description_en'],
                'ru' => $response['description_ru'],
            ]
        ]));
    }
}