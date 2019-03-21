<?php

namespace Otus\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Handler
 */
abstract class Handler extends AbstractLogger implements LoggerInterface
{
    /**
     * @var bool
     */
    protected $isEnabled = true;
    /**
     * @var string - Date format
     */
    protected $dateFormat = \DateTime::RFC2822;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * Enable the handler.
     *
     * @return self
     */
    public function enable(): self
    {
        $this->isEnabled = true;
        return $this;
    }

    /**
     * Disable the handler.
     *
     * @return self
     */
    public function disable(): self
    {
        $this->isEnabled = false;
        return $this;
    }

    /**
     * Route constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value)
        {
            if (property_exists($this, $attribute))
            {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * The current date.
     *
     * @return string
     * @throws \Exception
     */
    public function getDate(): string
    {
        return (new \DateTime())->format($this->dateFormat);
    }

    /**
     * Transform context to string.
     *
     * @param array $context
     * @return string|null
     */
    public function contextToString(array $context = []): ?string
    {
        return !empty($context) ? json_encode($context) : null;
    }

    /**
     * @inheritdoc
     */
    abstract public function log($level, $message, array $context = array()): void;
}
