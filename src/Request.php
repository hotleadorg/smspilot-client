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
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
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