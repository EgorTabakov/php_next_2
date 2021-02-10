<?php


use MyApp\Models\Goods;
use MyApp\Models\Orders;

class GoodsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetById()
    {
        $expected = [
            'id' => 2,
            'title' => 'Good 2',
            'price' => 182,
            'category_id' => 1,
            'info' => 'iinfo good',
        ];
        $actual = Goods::getById($expected['id']);

        self::assertEquals($expected, $actual);

    }


    public function testGetImageById()
    {
        $expected = [
            'id' => 1,
            'good_id' => 2,
            'url' => 'cart_pr_2.jpg',
            'title' => 'img-1',
        ];
        $actual = Goods::getImageById($expected['id']);

        self::assertEquals($expected, $actual);
    }

    public function testGetByCategory()
    {
        $allGoods = Goods::getAll();
        $expected = array_shift($allGoods);
        $goods = (Goods::getByCategory($expected['category_id']));
        $actual = array_shift($goods);
        self::assertEquals($expected, $actual);
    }

    public function testGetAll()
    {
        $goodsMockInstance = $this->getGoodsMock();
        $expected = [
            0 => [
                'id' => 1,
                'title' => 'Good 1',
                'price' => 550,
                'category_id' => 1,
                'info' => 'iinfo good',
            ],
        ];

        self::assertEquals($expected, $goodsMockInstance->getAll());

    }

    private function getGoodsMock()
    {
        return new class extends Goods {
            public static function getAll()
            {
                return [
                    [
                        'id' => 1,
                        'title' => 'Good 1',
                        'price' => 550,
                        'category_id' => 1,
                        'info' => 'iinfo good',
                    ],
                ];
            }
        };
    }

}