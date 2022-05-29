<?php

namespace Asteq\Logger;

use Asteq\Logger\Types\Type;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use SplObjectStorage;

final class Logger extends AbstractLogger implements LoggerInterface
{
    /* @var SplObjectStorage $loggers */
    private $loggers;

    public function __construct()
    {
        $this->loggers = new SplObjectStorage();
    }

    public function addLogger(object $obj, $info = null)
    {
        if ($obj instanceof Type) {
            $this->loggers->attach($obj, $info);
        }
    }

    public function removeLogger(object $obj)
    {
        $this->loggers->detach($obj);
    }

    public function log($level, $message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            if (!$logger instanceof Type) {
                continue;
            }

            if (!$logger->isEnabled()) {
                continue;
            }

            $logger->log($level, $message, $context);
        }
    }
}