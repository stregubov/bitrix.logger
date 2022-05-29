<?php

class asteq_logger extends CModule
{
    public $MODULE_ID = "asteq.logger";
    public $MODULE_NAME = "Asteq.Logger";
    public $MODULE_VERSION = "1.0.0";
    public $MODULE_VERSION_DATE = "2021-05-29 13:56:00";

    public function __construct()
    {
        $this->PARTNER_NAME = "Asteq";
        $this->PARTNER_URI = 'https://asteq.ru';
    }

    public function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
    }

    public function DoUninstall() {
        UnRegisterModule($this->MODULE_ID);
    }
}
