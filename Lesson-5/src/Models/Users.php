<?php

namespace MyApp\Models;

class Users extends Model
{
    const TABLE = 'users';

    public static function addUser($login, $password)
    {
        if (empty(self::get($login))) {

            if (empty($login) || empty($password)) {
                return;
            }
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = self::link()->prepare('INSERT INTO ' . self::TABLE . " SET user_login = :login, user_hash = :hash, user_password = :password ");
            $stmt->bindParam(':login', $login, \PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
            $stmt->bindParam(':hash', $hashPassword, \PDO::PARAM_STR);
            $stmt->execute();
        }
    return false;
    }

    public static function check($login, $password)
    {
        $user = self::get($login);
        if (!$user) {
            return false;
        }
        return password_verify($password, $user['user_hash']);

    }

    public static function get($login)
    {
        $stmt = self::link()->prepare('SELECT * FROM ' . self::TABLE . ' WHERE user_login = :login LIMIT 1');
        $stmt->bindParam('login', $login, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }
}
