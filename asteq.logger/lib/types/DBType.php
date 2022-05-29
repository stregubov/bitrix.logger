<?php

namespace Asteq\Logger\Types;

use PDO;


/**
 * Создание таблицы:
 *
 * CREATE TABLE asteq_log (
 *      id integer PRIMARY KEY,
 *      date date,
 *      level varchar(16),
 *      message text,
 *      context text
 * );
 */
final class DBType extends Type
{
    /**
     * @var string Data Source Name
     * @see http://php.net/manual/en/pdo.construct.php
     */
    private $dsn;
    /**
     * @var string Имя пользователя БД
     */
    private $username;
    /**
     * @var string Пароль пользователя БД
     */
    private $password;
    /**
     * @var string Имя таблицы
     */
    private $table = 'asteq_log';

    /**
     * @var PDO Подключение к БД
     */
    private $connection;

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = new PDO($this->dsn, $this->username, $this->password);
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = [])
    {
        $statement = $this->connection->prepare(
            'INSERT INTO ' . $this->table . ' (date, level, message, context) ' .
            'VALUES (:date, :level, :message, :context)'
        );

        $context = $this->contextStringify($context);
        $date = $this->getDate();

        $statement->bindParam(':date', $date);
        $statement->bindParam(':level', $level);
        $statement->bindParam(':message', $message);
        $statement->bindParam(':context', $context);
        $statement->execute();
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @param string $dsn
     */
    public function setDsn(string $dsn): void
    {
        $this->dsn = $dsn;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }
}