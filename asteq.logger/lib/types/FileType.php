<?php

namespace Asteq\Logger\Types;

final class FileType extends Type
{
    /* @var string $filePath */
    private $filePath;

    /**
     * @var string Шаблон сообщения
     */
    private $template = "{date} {level} {message}  userId - {user} {context}";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!is_dir($this->filePath)) {
            $dir = dirname($this->filePath);
            mkdir($dir);
        }

        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        $context['message'] = $message;
        $context['level'] = $level;

        file_put_contents($this->filePath, $this->getFormatter()->format($this->template, $context), FILE_APPEND);
    }
}