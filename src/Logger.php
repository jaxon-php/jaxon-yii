<?php

namespace Jaxon\Yii;

use Yii;

use Psr\Log\LoggerInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

class Logger extends AbstractLogger implements LoggerInterface
{
    public function log($sLevel, $sMessage, array $aContext = [])
    {
        $sMessage = rtrim((string)$sMessage, ' .') . '. ' . json_encode($aContext);

        // Map the PSR-3 severity to CodeIgniter log level.
        switch($sLevel)
        {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
                Yii::error($sMessage);
                break;
            case LogLevel::WARNING:
                Yii::warning($sMessage);
                break;
            case LogLevel::DEBUG:
                Yii::debug($sMessage);
                break;
            case LogLevel::NOTICE:
            case LogLevel::INFO:
                Yii::info($sMessage);
                break;
            default:
                throw new InvalidArgumentException("Unknown severity level");
        }
    }
}
