<?php

namespace Otus\Logger\Handlers;

use Otus\Logger\Handler;
use Psr\Log\LogLevel;

/**
 * Class SyslogHandler
 */
class SyslogHandler extends Handler
{
    /**
     * @var string
     */
    public $template = "{message} {context}";

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = []): void
    {
        $level = $this->resolveLevel($level);
        if ($level === null)
        {
            return;
        }

        syslog($level, trim(strtr($this->template, [
            '{message}' => $message,
            '{context}' => $this->contextStringify($context),
        ])));
    }

    /**
     * Transform log level to level for syslog()
     *
     * @see http://php.net/manual/en/function.syslog.php
     * @param $level
     * @return string|null
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
        return isset($map[$level]) ? $map[$level] : null;
    }
}
