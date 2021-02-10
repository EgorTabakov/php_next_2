<?php


namespace MyApp\Models;

class History extends Model
{
    const TABLE = 'history';

    public static function add($userId, $url)
    {
        $stmt = self::link()->prepare('INSERT INTO ' . self::TABLE . " SET user_id = :user_id, url = :url ");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
        $stmt->execute();
    }
    public static function getLast($userId, $count=5){
        return self::link()
->query(
    'SELECT * FROM ' . self::TABLE
    . ' WHERE user_id=' . (int)$userId
    . ' ORDER BY id DESC LIMIT ' . (int)$count)
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

}