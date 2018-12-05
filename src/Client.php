<?php

namespace SMSPilot;

use SMSPilot\Exception\SMSPilotException;

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
     * @link https://smspilot.ru/apikey.php#api1
     * @param Request $request
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function send($request, $format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '/api.php?send=%s&to=%s%s&apikey=%s&format=%s';
        return $this->syncResponseProcessing(
            file_get_contents(
                sprintf(
                    $requestUrl,
                    $request->getText(), $request->getPhone(), $request->getSender(true), $this->getApikey(), $format
                )
            )
        );
    }

    /**
     * send bulk SMS (API-2 ПАКЕТНАЯ ОТПРАВКИ ПЕРСОНАЛЬНЫХ СООБЩЕНИЙ)
     * @link https://smspilot.ru/apikey.php#api2
     * @param Request[] $requests
     * @return array
     */
    public function bulk($requests)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '/api2.php';
        $content = [
            'apikey' => $this->getApiKey(),
            'send' => []
        ];
        foreach ($requests as $request) {
            $content['send'] = $request->toArray();
        }
        $response = file_get_contents($requestUrl, false,
            stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json\r\n',
                    'content' => json_encode($content),
                ],
            ])
        );
        return json_decode($response, true);
    }

    /**
     * send hlr (API HLR (ЗАПРОС К БАЗЕ ОПЕРАТОРА))
     * @link https://smspilot.ru/apikey.php#hlr
     * @param string $phone
     * @param string $callbackUrl
     * @param string $format
     * @return string
     * @throws SMSPilotException
     */
    public function hlr($phone, $callbackUrl, $format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '/api.php?send=HLR&to=%s&callback=%s&format=%s&apikey=%s';
        return $this->asyncResponseProcessing(
            file_get_contents(
                sprintf($requestUrl, $phone, urlencode($callbackUrl), $format, $this->getApikey())
            )
        );
    }

    /**
     * send ping (API PING (СКРЫТОЕ СООБЩЕНИЕ))
     * @link https://smspilot.ru/apikey.php#ping
     * @param string $phone
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function ping($phone, $format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '/api.php?send=PING&to=%s&format=%s&apikey=%s';
        return $this->syncResponseProcessing(
            file_get_contents(
                sprintf($requestUrl, $phone, $format, $this->getApikey())
            )
        );
    }

    /**
     * send Viber (API VIBER)
     * @link https://smspilot.ru/apikey.php#viber
     * @param Request $request
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function sendViber($request, $format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '/api.php?send=%s&to=%s&from=VIBERSMS&format=%s&apikey=%s';
        return $this->syncResponseProcessing(
            file_get_contents(
                sprintf($requestUrl, $request->getText(), $request->getPhone(), $format, $this->getApikey())
            )
        );
    }

    /**
     * Request to register sender (API ИМЕНА ОТПРАВИТЕЛЯ)
     * @link https://smspilot.ru/apikey.php#sndr
     * @param string $sender
     * @param string $description
     * @param string $callbackUrl
     * @param bool $isTest
     * @param string $format
     * @return string
     * @throws SMSPilotException
     */
    public function registerSenderRequest($sender, $description, $callbackUrl, $isTest = true, $format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '/api.php?add_sender=%s&description=%s&callback=%s&test=%s&format=%s&apikey=%s';
        return $this->asyncResponseProcessing(
            file_get_contents(
                sprintf($requestUrl, $sender, $description, $callbackUrl, (bool)$isTest, $format, $this->getApikey())
            )
        );
    }

    /**
     * Get sender list
     * @link https://smspilot.ru/apikey.php#sndr
     * @param string $format
     * @return array
     */
    public function getSenders($format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . '?list=senders&format=%s&apikey=%s';
        return json_decode(
            file_get_contents(sprintf($requestUrl, $format, $this->getApiKey())),
            true
        )['senders'];
    }

    /**
     * API VOICESMS (ГОЛОСОВЫЕ СООБЩЕНИЯ)
     * @link https://smspilot.ru/apikey.php#voice
     * @param Request $request
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function voice($request, $format = self::JSON)
    {
        $request = new Request('GOLOS', urldecode($request->getPhone()), urldecode($request->getText()));
        return $this->send($request, $format);
    }

    /**
     * API ANTISPAM-TEMPLATE (АНТИСПАМ-ШАБЛОНЫ)
     * @link https://smspilot.ru/apikey.php#tpl
     * @param string $text
     * @param string $callbackUrl
     * @param string $format
     * @return string
     * @throws SMSPilotException
     */
    public function verifyTemplate($text, $callbackUrl, $format = self::JSON)
    {
        $requestUrl = self::ROOT_REQUEST_URL . 'api.php?add_template=%s&callback=%s&apikey=%s&format=%s';
        return $this->asyncResponseProcessing(
            file_get_contents(
                sprintf($requestUrl, $text, $callbackUrl, $this->getApikey(), $format)
            )
        );
    }

    /**
     * @param string $response
     * @return array
     * @throws SMSPilotException
     */
    private function syncResponseProcessing($response)
    {
        $response = json_decode($response, true);
        if (!isset($response['error'])) {
            return $response;
        }
        throw new SMSPilotException($response['description_ru']);
    }

    /**
     * @param string $response
     * @return string
     * @throws SMSPilotException
     */
    private function asyncResponseProcessing($response)
    {
        $response = json_decode($response, true);
        if (!isset($response['error'])) {
            return 'request was send';
        }
        throw new SMSPilotException($response['description_ru']);
    }

    /**
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }
}