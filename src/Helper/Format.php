<?php

namespace SMSPilot\Helper;

class Format
{
    /**
     * @param array $response
     * @return array
     */
    public static function response($response)
    {
        return [
            'phone' => $response['send']['phone'],
            'sms_id' => $response['send']['server_id'],
            'cost' => $response['send']['price'],
            'status' => $response['send']['status']
        ];
    }

    /**
     * @param bool $bool
     * @return int
     */
    public static function bool2int($bool)
    {
        return $bool === true ? 1 : 0;
    }
}