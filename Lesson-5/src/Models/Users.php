<?php

namespace MyApp\Models;

class Users extends Model
{
    const ROLE_ADMIN = 1;
    const ROLE_CONTENT = 2;
    const ROLE_USER = 3;

    const TABLE = 'users';
    const TABLE_ROLES = 'users_roles';

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
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $user['roles'] = self::getRoles($user['user_id']);

        return $user;
    }

    public static function getRoles($userId)
    {
        $rows = self::link()
            ->query('SELECT role FROM ' . self::TABLE_ROLES . ' WHERE user_id=' . (int)$userId)
            ->fetchAll(\PDO::FETCH_ASSOC);

        $roles = [];
        foreach ($rows as $row) {
            $roles[] = (int)$row['role'];
        }

        return $roles;
    }
}
