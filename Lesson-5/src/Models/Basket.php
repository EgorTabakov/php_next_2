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
        $_SESSION['basket']['goods'][$id]++;

    }

    public static function clear()
    {
        self::init(true);
    }

    private static function init($force = false)
    {
        if ($force || empty($_SESSION['basket'])) {
            $_SESSION['basket'] = [
                'count' => 0,
                'goods' => [],
            ];
        }
    }
}