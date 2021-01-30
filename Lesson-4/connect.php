<?php

class DB
{
    public const TABLE_ITEMS = 'items';
    public const countView = 5;
    public $startView = 0;
    private static $config = [
        'dsn' => 'mysql:host=localhost;dbname=less4',
        'user' => 'root',
        'psw' => '2712',
    ];

    private static $instance;
    private $link;

    public function getAllData($tableName)
    {
        try {
            return $this->link
                ->query("SELECT * FROM {$tableName}")
                ->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return false;
        }
    }

    public function getCount($tableName)
    {
        try {
            return $this->link
                ->query("SELECT COUNT(*) FROM {$tableName}")
                ->fetchColumn();
        } catch (Throwable $e) {
            return false;
        }
    }

    public function getLimitData($tableName, int $startView, int $countView)

    {
        try {
            return $this->link
                ->query('SELECT * FROM ' . $tableName . ' LIMIT ' . $startView . ' , ' . $countView)
                ->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return false;
        }
    }


    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->link = new PDO(
            self::$config['dsn'],
            self::$config['user'],
            self::$config['psw']
        );

    }
}

