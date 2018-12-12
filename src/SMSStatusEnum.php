<?php

namespace SMSPilot;

/**
 * @link https://smspilot.ru/download/SMSPilotRu-HTTP-v1.9.17.pdf
 * @package SMSPilot
 */
class SMSStatusEnum
{
    CONST FAILED = -2;
    CONST UNDELIVERED = -1;
    CONST SENT = 0;
    CONST QUEUE = 1;
    CONST DELIVERED = 2;
    CONSt DELAYED_SEND = 3;

    static $ERRORS = [
        self::FAILED => 'Failed',
        self::UNDELIVERED => 'Undelivered',
        self::SENT => 'Sent',
        self::QUEUE => 'Queue',
        self::DELIVERED => 'Delivered',
        self::DELAYED_SEND => 'Delayed send',
    ];
}