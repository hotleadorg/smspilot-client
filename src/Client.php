<?php

namespace SMSPilot;

use SMSPilot\Exception\SMSPilotException;

class Client
{

    const URL_API_V1 = 'http://smspilot.ru/api.php';
    const URL_API_V2 = 'http://smspilot.ru/api2.php';

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
     * @param string $url
     * @param array $params
     * @return array
     * @throws SMSPilotException
     */
    private function sendViaAPIv1($url, $params)
    {
        return (new Processing(
            Format::getUrlWithParams(
                $url,
                $params
            )
        ))->sendRequest()->getRequestResult();
    }

    /**
     * Send SMS (API-1 ОДИНОЧНЫЕ SMS/РАССЫЛКА/СТАТУС/БАЛАНС)
     * Response format
     * {
     *  'send': [
     *      [
     *          'server_id': '123456789'
     *          'phone':  '79999999999'
     *          'price': '2.22',
     *          'status': '0'
     *      ]
     *  ],
     *  'balance': '100.12',
     *  'cost': '2.22'
     * }
     * @link https://smspilot.ru/apikey.php#api1
     * @param Request $request
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function send($request, $format = self::JSON)
    {
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'send' => $request->getText(),
                'from' => $request->getSender(),
                'to' => $request->getPhone(),
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
        );
    }

    /**
     * send hlr (API HLR (ЗАПРОС К БАЗЕ ОПЕРАТОРА))
     * @link https://smspilot.ru/apikey.php#hlr
     * @param string $phone
     * @param string $callbackUrl
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function hlr($phone, $callbackUrl, $format = self::JSON)
    {
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'send' => 'HLR',
                'from' => $phone,
                'callback' => $callbackUrl,
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
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
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'send' => 'PING',
                'to' => $phone,
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
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
    public function viber($request, $format = self::JSON)
    {
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'send' => $request->getText(),
                'to' => $request->getPhone(),
                'from' => 'VIBERSMS',
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
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
     * @return array
     * @throws SMSPilotException
     */
    public function registerSenderRequest($sender, $description, $callbackUrl, $isTest = true, $format = self::JSON)
    {
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'add_sender' => $sender,
                'description' => $description,
                'callback' => $callbackUrl,
                'test' => (bool)$isTest,
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
        );
    }

    /**
     * Get sender list
     * @link https://smspilot.ru/apikey.php#sndr
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function getSenders($format = self::JSON)
    {
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'list=senders',
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
        )['senders'];
    }

    /**
     * API ANTISPAM-TEMPLATE (АНТИСПАМ-ШАБЛОНЫ)
     * @link https://smspilot.ru/apikey.php#tpl
     * @param string $text
     * @param string $callbackUrl
     * @param string $format
     * @return array
     * @throws SMSPilotException
     */
    public function verifyTemplate($text, $callbackUrl, $format = self::JSON)
    {
        return $this->sendViaAPIv1(
            self::URL_API_V1,
            [
                'add_template' => $text,
                'callback' => $callbackUrl,
                'apikey' => $this->getApikey(),
                'format' => $format,
            ]
        );
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
        $request = new Request('GOLOS', $request->getPhone(), $request->getText());
        return $this->send($request, $format);
    }

    /**
     * send bulk SMS (API-2 ПАКЕТНАЯ ОТПРАВКИ ПЕРСОНАЛЬНЫХ СООБЩЕНИЙ)
     * Response format
     * {
     *  'send': [
     *      [
     *          'id': 0
     *          'server_id': '123456789',
     *          'from':  'sender name',
     *          'to': '79999999999',
     *          'text': 'hello world!',
     *          'parts': '1',
     *          'status': '0',
     *          'error: '0',
     *          'send_datetime': '',
     *          'country': 'RU',
     *          'operator': 'YOTA',
     *          'price': '2.22'
     *      ]
     *  ],
     *  'server_packet_id': '987654321',
     *  'balance': '100.12',
     *  'cost': '2.22'
     * }
     * @link https://smspilot.ru/apikey.php#api2
     * @param Request[] $requests
     * @return array
     */
    public function bulk($requests)
    {
        $content = [
            'apikey' => $this->getApiKey(),
            'send' => []
        ];
        foreach ($requests as $request) {
            $content['send'][] = $request->toArray();
        }
        $response = file_get_contents(
            self::URL_API_V2,
            false,
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
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }
}