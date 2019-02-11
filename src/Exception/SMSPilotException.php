<?php

namespace SMSPilot\Exception;

use SMSPilot\SMSPilotErrorEnum;

class SMSPilotException extends \Exception
{
    /**
     * @return integer
     */
    public function getErrorCode()
    {
        return (int)$this->message;
    }

    /**
     * @return string
     */
    public function getDescriptionEn()
    {
        return SMSPilotErrorEnum::$ERRORS[$this->getErrorCode()]['en'];
    }

    /**
     * @return string
     */
    public function getDescriptionRu()
    {
        return SMSPilotErrorEnum::$ERRORS[$this->getErrorCode()]['ru'];
    }
}