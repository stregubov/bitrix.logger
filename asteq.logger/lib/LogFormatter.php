<?php

namespace Asteq\Logger;

use Bitrix\Main\Type\DateTime;

use function is_array_assoc;

final class LogFormatter implements LogFormatterInterface
{
    /* @var string $date */
    private $date;

    /* @var int $user */
    private $user;

    /* @var string $user */
    private $delimiter;

    public function __construct()
    {
        $this->date = (new DateTime())->format(DATE_RFC3339);
        $this->delimiter = PHP_EOL;

        global $USER;
        if ($USER->IsAuthorized()) {
            $this->user = $USER->getId();
        }
    }

    public function format(string $message, array $context = []): string
    {
        $templateData = [];

        if (!empty($context) && self::isArrayAssoc($context)) {
            $keys = array_keys($context);

            foreach ($keys as $key) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $context[$key];
                    continue;
                }

                $templateData['{'.$key.'}'] = $context[$key];
            }
        }

        $templateData['{date}'] = $this->date;
        $templateData['{user}'] = $this->user > 0? $this->user: 'none';
        $templateData['{delimiter}'] = $this->delimiter;
        $templateData['{context}'] = !empty($context)? json_encode($context, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES): "";

        return trim(strtr($message, $templateData)) . $this->delimiter;
    }

    private static function isArrayAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}