<?php


namespace MyApp\Models;


class Orders extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PROGRESS = 2;
    const STATUS_REJECTED = 3;
    const STATUS_DONE = 4;

    const TABLE_ORDERS = 'orders';
    const TABLE_ORDERS_GOODS = 'orders_goods';

    private static $statuses = [
        self::STATUS_NEW => 'New',
        self::STATUS_PROGRESS => 'In progress',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_DONE => 'Finished',
    ];

    public static function getStatuses()
    {
        return self::$statuses;
    }

    public static function setStatus($id, $status)
    {
        if (!isset(self::$statuses[$status])) {
            return;
        }

        self::link()->exec('UPDATE ' . self::TABLE_ORDERS . ' SET status=' . (int)$status . ' WHERE id=' . (int)$id);
    }

    public static function getAllRows()
    {
        return self::link()->query('
            SELECT
            orders.id, orders.`date`,orders.`status`,
            orders_goods.good_id,
            orders_goods.price,orders_goods.`count`,
            goods.title, goods.category_id,
            users.user_login
            FROM orders
            JOIN orders_goods ON orders.id=orders_goods.order_id
            JOIN users ON orders.user_id=users.user_id
            JOIN goods ON goods.id=orders_goods.good_id
            ORDER BY orders.id DESC
        ')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        $rows = static::getAllRows();

        $orders = [];
        foreach ($rows as $row) {
            $id = $row['id'];

            if (!isset($orders[$id])) {
                $orders[$id] = [
                    'id' => $id,
                    'date' => $row['date'],
                    'status' => $row['status'],
                    'login' => $row['login'],
                    'sum' => 0,
                    'goods' => [],
                ];
            }

            $orders[$id]['goods'][] = [
                'id' => $row['good_id'],
                'price' => $row['price'],
                'count' => $row['count'],
                'title' => $row['title'],
                'categoryId' => $row['category_id'],
                'sum' => $row['count'] * $row['price'],
            ];
            $orders[$id]['sum'] += $row['count'] * $row['price'];
        }

        return $orders;
    }

    public static function add($userId, $goodsCounts)
    {
        self::link()->exec(
           'INSERT INTO ' . self::TABLE_ORDERS
            . ' SET user_id=' . (int)$userId
            . ', status=' . self::STATUS_NEW
        );

        $orderId = self::link()->lastInsertId();
        foreach ($goodsCounts as $id => $count) {
            $good = Goods::getById($id);

            self::link()->exec('INSERT INTO ' . self::TABLE_ORDERS_GOODS
                . ' SET order_id=' . $orderId
                . ', good_id=' . (int)$id
                . ', price=' . $good['price']
                . ', `count`=' . (int)$count
            );
        }
        return $orderId;
    }
}