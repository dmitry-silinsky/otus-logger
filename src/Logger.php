<?php

namespace Otus\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 */
class Logger extends AbstractLogger implements LoggerInterface
{
    /**
     * @var \Iterator
     */
    protected $handlerStorage;

    public function __construct(\Iterator $handlerStorage)
    {
        $this->handlerStorage = $handlerStorage;
    }

    /**
     * @return \Iterator
     */
    public function getHandlerStorage(): \Iterator
    {
        return $this->handlerStorage;
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = []): void
    {
        foreach ($this->handlerStorage as $route) {
            if (!$route instanceof Handler || !$route->isEnabled()) {
                continue;
            }
            $route->log($level, $message, $context);
        }
    }
}
