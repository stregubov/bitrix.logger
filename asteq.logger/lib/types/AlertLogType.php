<?php

namespace Asteq\Logger\Types;

use Bitrix\Main\Mail\Event;

class AlertLogType extends Type
{
    /*
     * @var string $eventName
     */
    private $eventName = 'ASTEQ_LOG';

    /**
     * @var string Шаблон сообщения
     */
    private $template = "{date}{delimiter}{level}{delimiter}{message}{delimiter}userId - {user}{delimiter}{context}";

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        $context['message'] = $message;
        $context['level'] = $level;

        $message = $this->getFormatter()->format($this->template, $context);

        if (!empty($this->eventName) && !empty($message)) {
            Event::send([
                "EVENT_NAME" => $this->eventName,
                "LID" => SITE_ID,
                "C_FIELDS" => [
                    'MESSAGE' => $message
                ]
            ]);
        }
    }
}