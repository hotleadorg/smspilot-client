<?php

namespace SMSPilot;

class Format
{
    /**
     * Format constructor.
     * @param string $url
     * @param array $params
     * @return string
     */
    public static function getUrlWithParams($url, $params)
    {
        return sprintf('%s?%s', $url, http_build_query($params));
    }
}