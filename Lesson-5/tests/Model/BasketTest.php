<?php

class BasketTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        $_SESSION['basket'] = null;
    }

    public function testGet()
    {
        $actual = \MyApp\Models\Basket::get();

        self::assertEquals([
            'count' => 0,
            'goods' => [],
        ], $actual);
    }

    public function testAdd()
    {
        \MyApp\Models\Basket::add(4);
        \MyApp\Models\Basket::add(4);
        \MyApp\Models\Basket::add(5);

        $basket = \MyApp\Models\Basket::get();
        self::assertEquals([
            'count' => 3,
            'goods' => [
                4 => 2,
                5 => 1,
            ],
        ], $basket);
    }

    public function testClear()
    {
        $_SESSION['basket'] = [
            'count' => 1,
            'goods' => [3 => 1],
        ];

        \MyApp\Models\Basket::clear();

        self::assertEquals([
            'count' => 0,
            'goods' => [],
        ], $_SESSION['basket']);
    }

    /**
     * @dataProvider initProvider
     * @param $initialBasket
     * @param $force
     * @param $expectedBasket
     */
    public function testInit($initialBasket, $force, $expectedBasket)
    {
        $_SESSION['basket'] = $initialBasket;

        \MyApp\Models\Basket::init($force);

        self::assertEquals($expectedBasket, $_SESSION['basket']);
    }

    public function initProvider()
    {
        $empty = null;
        $nonEmpty = [
            'count' => 1,
            'goods' => [3 => 1],
        ];
        $initedBasket = [
            'count' => 0,
            'goods' => [],
        ];

        return [
            [$empty, false, $initedBasket],
            [$empty, true, $initedBasket],
            [$nonEmpty, false, $nonEmpty],
            [$nonEmpty, true, $initedBasket],
        ];
    }
}