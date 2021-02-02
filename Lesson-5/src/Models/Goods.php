<?php

namespace MyApp\Models;

class Goods extends Model
{
    const TABLE = 'goods';

    public static function add($title, $price)
    {
        if (empty($title) || empty($price)) {
            return;
        }

        $stmt = self::link()->prepare('INSERT INTO ' . self::TABLE . " SET title = :title, price = :price ");
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function getAll()
    {
        return self::db()->getAllData(self::TABLE);
    }
}
