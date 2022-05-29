# bitrix.logger

Модуль логгирования для CMS 1C-Битрикс, совместимый с PSR-3 (https://www.php-fig.org/psr/psr-3/). Для установки модуля нужно закинуть папку asteq.logger с bitrix/modules или local/modules


## Конфигурация

Для настроек можно воспользовать следующим кодом:

```php
$logger = new Asteq\Logger\Logger();

$logger->addLogger(new Asteq\Logger\Types\FileType([
    'isEnable' => true,
    'filePath' => $_SERVER['DOCUMENT_ROOT'].'/logs/log'.date('d.m.Y').".txt",
]));
```

Выше создается базовый объект Logger, которому добавляется один из возможных типов хранилища логов - файлы. На текущий момент доступны файлы, syslog и база данных через PDO (https://www.php.net/manual/ru/book.pdo.php).

Так же для настройки логгера можно использовать ServiceLocator Битрикса (https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=14032).

Код ниже нужно вставить в файл bitrix/.settings.php 

```php

return [
...
'services' => [
        'value' => [
            'asteq.logger.Logger' => [
                'constructor' => static function () {
                    $logger = new Asteq\Logger\Logger();

                    $logger->addLogger(new Asteq\Logger\Types\FileType([
                        'isEnable' => true,
                        'filePath' => $_SERVER['DOCUMENT_ROOT'].'/logs/log'.date('d.m.Y').".txt",
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
...
];

```

Выше показаны примеры добавления логгеров syslog и базы данных.

## Использование

Создаем объект логгера явно и добавляем нужное хранилище как описано выше, либо вытаскиваем из локатора

```php
$serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();

$logger = null;
if ($serviceLocator->has('asteq.logger.Logger')) {
    /* @var \Asteq\Logger\Logger $logger */
    $logger = $serviceLocator->get('asteq.logger.Logger');
}
```
и используем

```php
$arr = ['test' => 5, 'test2' => 6];

if (!is_null($logger)) {
    $logger->info('test', $arr);
}
```


