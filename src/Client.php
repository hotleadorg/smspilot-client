<?php

namespace SMSPilot;

use SMSPilot\Exception\Exception;
use SMSPilot\Helper\Format;

class Client
{
    const ROOT_REQUEST_URL = 'http://smspilot.ru';

    const TEXT = 'text';
    const XML = 'xml';
    const JSON = 'json';

    /**
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * Client constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Send SMS (API-1 ОДИНОЧНЫЕ SMS/РАССЫЛКА/СТАТУС/БАЛАНС)
     * @param Request $request
     * @param string $format
     * @return array
     * @throws Exception
     */
    public function send($request, $format = self::JSON)
    {
        return $this->syncResponseProcessing(
            file_get_contents(
                sprintf(
                    self::ROOT_REQUEST_URL . '/api.php?send=%s&to=%s%s&apikey=%s&format=%s',
                    $request->getText(), $request->getPhone(), $request->getSender(true), $this->getApikey(), $format
                )
            )
        );
    }

    /**
     * send bulk SMS (API-2 ПАКЕТНАЯ ОТПРАВКИ ПЕРСОНАЛЬНЫХ СООБЩЕНИЙ)
     * @param Request[] $requests
     * @return array
     */
    public function bulk($requests)
    {
        $requestUri = self::ROOT_REQUEST_URL . '/api2.php';
        $content = [
            'apikey' => $this->getApiKey(),
            'send' => []
        ];
        foreach ($requests as $request) {
            $content['send'] = $request->toArray();
        }
        $response = file_get_contents($requestUri, false,
            stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/json\r\n",
                    'content' => json_encode($content),
                ],
            ])
        );
        return json_decode($response, true);
    }

    /**
     * send hlr (API HLR (ЗАПРОС К БАЗЕ ОПЕРАТОРА))
     * @param string $phone
     * @param string $callbackUrl
     * @param string $format
     * @return string
     * @throws Exception
     */
    public function hlr($phone, $callbackUrl, $format = self::JSON)
    {
        return $this->asyncResponseProcessing(
            file_get_contents(
                sprintf(
                    self::ROOT_REQUEST_URL . '/api.php?send=HLR&to=%s&callback=%s&format=%s&apikey=%s',
                    $phone, urlencode($callbackUrl), $format, $this->getApikey()
                )
            )
        );
    }

    /**
     * send ping (API PING (СКРЫТОЕ СООБЩЕНИЕ))
     * @param string $phone
     * @param string $format
     * @return array
     * @throws Exception
     */
    public function ping($phone, $format = self::JSON)
    {
        return $this->syncResponseProcessing(
            file_get_contents(
                sprintf(
                    self::ROOT_REQUEST_URL . "/api.php?send=PING&to=%s&format=%s&apikey=%s",
                    $phone, $format, $this->getApikey()
                )
            )
        );
    }

    /**
     * send Viber (API VIBER)
     * @param Request $request
     * @param string $format
     * @return array
     * @throws Exception
     */
    public function sendViber($request, $format = self::JSON)
    {
        return $this->syncResponseProcessing(
            file_get_contents(
                sprintf(
                    self::ROOT_REQUEST_URL . "/api.php?send=%s&to=%s&from=VIBERSMS&format=%s&apikey=%s",
                    $request->getText(), $request->getPhone(), $format, $this->getApikey()
                )
            )
        );
    }

    /**
     * Request to register sender (API ИМЕНА ОТПРАВИТЕЛЯ)
     * @param string $sender
     * @param string $description
     * @param string $callbackUrl
     * @param bool $isTest
     * @param string $format
     * @return string
     * @throws Exception
     */
    public function registerSenderRequest($sender, $description, $callbackUrl, $isTest = true, $format = self::JSON)
    {
        return $this->asyncResponseProcessing(
            file_get_contents(
                sprintf(
                    self::ROOT_REQUEST_URL .
                    '/api.php?add_sender=%s&description=%s&callback=%s&test=%s&format=%s&apikey=%s',
                    $sender, $description, $callbackUrl, Format::bool2int($isTest), $format, $this->getApikey()
                )
            )
        );
    }

    /**
     * Get sender list
     * @param string $format
     * @return array
     */
    public function getSenders($format = self::JSON)
    {
        return json_decode(
            file_get_contents(
                sprintf(self::ROOT_REQUEST_URL . '?list=senders&format=%s&apikey=%s', $format, $this->getApiKey())
            ),
            true
        )['senders'];
    }

    /**
     * @param string $response
     * @return array
     * @throws Exception
     */
    private function syncResponseProcessing($response)
    {
        $response = json_decode($response, true);
        if (!isset($response['error'])) {
            return $response;
        }
        throw new Exception($response['description_ru']);
    }

    /**
     * @param string $response
     * @return string
     * @throws Exception
     */
    private function asyncResponseProcessing($response)
    {
        $response = json_decode($response, true);
        if (!isset($response['error'])) {
            return "request was send";
        }
        throw new Exception($response['description_ru']);
    }

    /**
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }
}
