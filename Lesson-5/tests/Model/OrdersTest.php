<?php


namespace MyApp\Models;

use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    public function testGetAll()
    {
        $ordersMockInstance = $this->getOrdersMock();

        $expected = [
            1 => [
                'id' => 1,
                'date' => '123123',
                'status' => 1,
                'login' => 'admin',
                'sum' => 800,
                'goods' => [
                    [
                        'id' => 123,
                        'price' => 100,
                        'count' => 2,
                        'title' => 'Foo',
                        'categoryId' => 5,
                        'sum' => 200,
                    ],
                    [
                        'id' => 234,
                        'price' => 200,
                        'count' => 3,
                        'title' => 'Bar',
                        'categoryId' => 6,
                        'sum' => 600,
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $ordersMockInstance->getAll());
    }

    private function getOrdersMock()
    {
        return new class extends Orders {
            public static function getAllRows()
            {
                return [
                    [
                        'id' => 1,
                        'date' => '123123',
                        'status' => 1,
                        'login' => 'admin',
                        'good_id' => 123,
                        'price' => 100,
                        'count' => 2,
                        'title' => 'Foo',
                        'category_id' => 5,
                    ],
                    [
                        'id' => 1,
                        'date' => '123123',
                        'status' => 1,
                        'login' => 'admin',
                        'good_id' => 234,
                        'price' => 200,
                        'count' => 3,
                        'title' => 'Bar',
                        'category_id' => 6,
                    ],
                ];
            }
        };
    }
}