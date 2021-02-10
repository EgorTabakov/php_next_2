<?php


namespace MyApp\Models;


class Basket extends Model
{
    public static function get()
    {
        self::init();

        return $_SESSION['basket'];
    }

    public static function add($id)
    {
        self::init();

        $_SESSION['basket']['count']++;
        if (!isset($_SESSION['basket']['goods'][$id])) {
            $_SESSION['basket']['goods'][$id] = 0;
        }
        $_SESSION['basket']['goods'][$id]++;
    }

    public static function clear()
    {
        self::init(true);
    }

    public static function init($force = false)
    {
        if ($force || empty($_SESSION['basket'])) {
            $_SESSION['basket'] = [
                'count' => 0,
                'goods' => [],
            ];
        }
    }
}