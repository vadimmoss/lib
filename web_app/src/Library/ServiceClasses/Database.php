<?php

namespace Library\ServiceClasses;

use Library\Exceptions\DatabaseException;


class Database
{
    private $pdo;
    private static $connection;           // Статическая переменная в которой хранится обьект базы нанных
                                            // чтобы не создавать новый екземпляр обьекта БД каждый раз
                                            // Чтобы обратиться к базе данных надо писать Database::getConnection()

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DatabaseException('Ошибка подключения к базе даных: ' . $e->getMessage());
        }

    }


    public static function getConnection(): self
    {
        if (self::$connection === null) {
            self::$connection = new self();
        }
        return self::$connection;
    }

    public function sqlQuery(string $queryString, $parameters = [], $class = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($queryString);
        $result = $sth->execute($parameters);
        if (false === $result) {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $class);   //Переобразование в обьект и вывод по указаному классу.
    }

    public function sqlQueryNonClass(string $sql): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function simplesqlQuery(string $sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }
        return $sth->fetchColumn();
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}