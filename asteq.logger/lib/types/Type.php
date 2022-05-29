<?php

namespace Asteq\Logger\Types;

use DateTime;
use DateTimeInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

abstract class Type extends AbstractLogger implements LoggerInterface
{
    /* @var bool $isEnabled */
    private $isEnabled = true;

    /* @var string $dateFormat */
    private $dateFormat = DateTimeInterface::RFC2822;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     */
    public function setIsEnabled(bool $isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            $methodName = "set$attribute";
            if (method_exists($this, $methodName)) {
                $this->{$methodName}($value);
                continue;
            }

            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * Текущая дата
     *
     * @return string
     */
    public function getDate(): string
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * Преобразование $context в строку
     *
     * @param array $context
     * @return string
     */
    public function contextStringify(array $context = []): ?string
    {
        return !empty($context) ? json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
    }
}