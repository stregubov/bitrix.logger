<?php

class asteq_logger extends CModule
{
    public $MODULE_ID = "asteq.logger";
    public $MODULE_NAME = "Asteq.Logger";
    public $MODULE_VERSION = "1.0.1";
    public $MODULE_VERSION_DATE = "2022-05-31 21:27:00";

    public function __construct()
    {
        $this->PARTNER_NAME = "Asteq";
        $this->PARTNER_URI = 'https://asteq.ru';
    }

    public function doInstall()
    {
        $this->addMailEvent();
        RegisterModule($this->MODULE_ID);
    }

    public function doUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
    }

    private function addMailEvent()
    {
        $arrCeventRes = [];
        $arrCeventTypes = [
            [
                'LID' => SITE_ID,
                'EVENT_NAME' => 'ASTEQ_LOG',
                'NAME' => 'Отправка лога',
                'DESCRIPTION' => '#MESSAGE# сообщение',
            ],
        ];

        $arrCeventTemplates = [
            'ASTEQ_LOG' => [
                'ACTIVE' => 'Y',
                'EVENT_NAME' => 'ASTEQ_LOG',
                'LID' => [SITE_ID],
                'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
                'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
                'SUBJECT' => 'Лог',
                'BODY_TYPE' => 'text',
                'MESSAGE' => '#MESSAGE#',
            ]
        ];

        $et = new CEventType;
        foreach ($arrCeventTypes as $arrCeventType) {
            $res = $et->Add($arrCeventType);
            if (!$res) {
                echo $et->LAST_ERROR;
            } else {
                $arrCeventRes[$res] = $arrCeventType['EVENT_NAME'];
            }
        }

        if (is_array($arrCeventRes)) {
            $em = new CEventMessage;
            foreach ($arrCeventRes as $cEventTypeName) {
                $res_em = $em->Add($arrCeventTemplates[$cEventTypeName]);

                if (!$res_em) {
                    echo $em->LAST_ERROR;
                }
            }
        }
    }
}
