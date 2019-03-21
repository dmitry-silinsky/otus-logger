<?php

namespace Otus\Logger\Handlers;

use Otus\Logger\Handler;

/**
 * Class FileHandler
 */
class FileHandler extends Handler
{
    /**
     * @var string - Path to log file
     */
    protected $path;
    /**
     * @var string - Message template
     */
    protected $msgTemplate = '{date} {level} {message} {context}';

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMsgTemplate(): string
    {
        return $this->msgTemplate;
    }

    /**
     * FileRoute constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!file_exists($this->path)) {
            touch($this->path);
        }
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = array()): void
    {
        file_put_contents($this->path, trim(strtr($this->msgTemplate, [
            '{date}' => $this->getDate(),
            '{level}' => $level,
            '{message}' => $message,
            '{context}' => $this->contextToString($context),
        ])) . PHP_EOL, FILE_APPEND);
    }
}
