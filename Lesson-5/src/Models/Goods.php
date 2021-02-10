<?php

namespace MyApp\Models;

class Goods extends Model
{
    const TABLE = 'goods';
    const TABLE_IMAGE = 'image';

    public static function getById($id)
    {
        return self::db()->getById(self::TABLE, $id);
    }

    public static function getImageById($id)
    {
        return self::db()->getById(self::TABLE_IMAGE, $id);
    }

    public static function getByCategory($id)
    {
        return self::link()
            ->query('SELECT * FROM ' . self::TABLE . ' WHERE category_id=' .(int)$id)
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

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