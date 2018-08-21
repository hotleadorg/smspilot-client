<?php

namespace SMSPilot;

class Request
{
    /**
     * @var string $phone
     */
    private $phone;
    /**
     * @var string $sender
     */
    private $sender;
    /**
     * @var string $text
     */
    private $text;

    /**
     * Request constructor.
     * @param string $phone
     * @param string $sender
     * @param string $text
     */
    public function __construct($sender, $phone, $text)
    {
        $this->phone = $phone;
        $this->sender = $sender;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return urlencode($this->phone);
    }

    /**
     * @param bool $format
     * @return string
     */
    public function getSender($format = false)
    {
        return $format === false ? $this->sender : sprintf("&from=%s", $this->sender);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return urlencode($this->text);
    }

    public function toArray()
    {
        return [
            'from' => $this->getSender(),
            'to' => $this->getPhone(),
            'text' => $this->getText()
        ];
    }
}