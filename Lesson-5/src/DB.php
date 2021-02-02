<?php

namespace MyApp;

class DB
{
    private $link;

    public function getLink(): \PDO
    {
        return $this->link;
    }

    public function getCount($tableName)
    {
        return $this->link
            ->query("SELECT COUNT(*) FROM {$tableName}")
            ->fetchColumn();
    }

    public function getPart($tableName, int $start, int $limit)
    {
        try {
            return $this->link
                ->query("SELECT * FROM {$tableName} LIMIT {$start},{$limit}")
                ->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getAllData($tableName)
    {
        try {
            return $this->link
                ->query('SELECT * FROM ' . $tableName)
                ->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getById($tableName, $id)
    {
        try {
            return $this->link
                ->query('SELECT * FROM ' . $tableName . ' WHERE id = ' . (int)$id)
                ->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function __construct($config)
    {
        try {
            $this->link = new \PDO(
                $config['dsn'],
                $config['user'],
                $config['pwd']
            );
        } catch (\Throwable $e) {
            die ($e->getMessage());
        }

    }
}