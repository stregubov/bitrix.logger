<?php

namespace Asteq\Logger;

interface LogFormatterInterface
{
    public function format(string $message, array $context = []): string;
}