<?php

namespace Asteq\Logger\Types;

use Psr\Log\LogLevel;

final class SyslogType extends Type
{
    /**
     * @var string Шаблон сообщения
     */
    public $template = "{message} {context}";

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = [])
    {
        $level = $this->resolveLevel($level);
        if ($level === null) {
            return;
        }

        syslog($level, $this->getFormatter()->format($this->template, $context));
    }

    /**
     * Преобразование уровня логов в формат подходящий для syslog()
     *
     * @see http://php.net/manual/en/function.syslog.php
     * @param $level
     * @return ?string
     */
    private function resolveLevel($level): ?string
    {
        $map = [
            LogLevel::EMERGENCY => LOG_EMERG,
            LogLevel::ALERT => LOG_ALERT,
            LogLevel::CRITICAL => LOG_CRIT,
            LogLevel::ERROR => LOG_ERR,
            LogLevel::WARNING => LOG_WARNING,
            LogLevel::NOTICE => LOG_NOTICE,
            LogLevel::INFO => LOG_INFO,
            LogLevel::DEBUG => LOG_DEBUG,
        ];
        
        return $map[$level] ?? null;
    }
}