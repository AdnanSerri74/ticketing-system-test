<?php

namespace app\Core;

use PDO;
use PDOStatement;

class DB
{
    protected PDO $connection;

    protected PDOStatement $statement;

    protected bool $executed = false;

    public function __construct()
    {
        $dsn = $this->formatDSN();

        $this->connection = new PDO($dsn, options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    private function formatDSN(): string
    {
        $connection = env('DB_CONNECTION');
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $charset = env('DB_CHARSET');

        return "$connection:host=$host;port=$port;dbname=$database;user=$username;password=$password;charset=$charset";
    }

    public function query(string $query): DB
    {
        $this->executed = $this->prepare($query)->statement()->execute();

        return $this;
    }

    public function prepare(string $query): DB
    {
        $this->statement = $this->connection->prepare($query);

        return $this;
    }

    public function get(): array|false
    {
        return $this->statement->fetchAll();
    }

    public function find(): array|false
    {
        return $this->statement->fetch();
    }

    public function findOrFail(): array|false
    {
        $result = $this->statement->fetch();

        if (!$result)
            abort();

        return $result;
    }

    public function statement(): PDOStatement
    {
        return $this->statement;
    }

    public function executed(): bool
    {
        return $this->executed;
    }

    public function lastInsertedID(): string|false
    {
        return $this->connection->lastInsertId();
    }
}