<?php

return [
    'services' => [
        'value' => [
            'asteq.logger.Logger' => [
                'constructor' => static function () {
                    $logger = new Asteq\Logger\Logger();

                    $logger->addLogger(new Asteq\Logger\Types\FileType([
                        'isEnable' => true,
                        'filePath' => $_SERVER['DOCUMENT_ROOT'].'/logs/log'.date('d.m.Y').".txt",
                    ]));

                    $logger->addLogger(new Asteq\Logger\Types\AlertLogType([
                        'isEnable' => true
                    ]));

//                    $logger->addLogger(new Asteq\Logger\Types\DBType([
//                        'isEnable' => true,
//                        'dsn' => 'sqlite:data/default.sqlite',
//                        'table' => 'default_log',
//                    ]));
//
//                    $logger->addLogger(new Asteq\Logger\Types\SyslogType([
//                        'isEnable' => true,
//                    ]));

                    return $logger;
                },
            ],
        ],
        'readonly' => true,
    ]
];