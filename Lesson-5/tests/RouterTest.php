<?php

class RouterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider parseProvider
     * @param $url
     * @param $expected
     */

public function testParse($url, $expected)
{
    $router  = new \MyApp\Router([
        'login' => 'account/login',
        'logout' => 'account/logout',
        'basket' => 'account/basket',
        'order' => 'account/order',
        'catalog\/([0-9]+)\/([0-9]+)' => 'catalog/good',
        'catalog\/([0-9]+)' => 'catalog/category',
        'catalog' => 'catalog/index',
        '(\w+)\/(\w+)' => '<controller>/<action>',
        '(\w+)' => '<controller>/index',
        '^$' => 'index/index',
        '(.*)' => 'index/error',
    ]);
    self::assertEquals($expected, $router->parse($url));

}
public function parseProvider()
{
return [
    ['/login', ['account', 'login', []]],
    ['/catalog', ['catalog', 'index', []]],
    ['/catalog/123/234', ['catalog', 'good', ['123','234']]],
    ['/', ['index', 'index', []]],
    ['foo/bar', ['foo', 'bar', []]],
    ['foo', ['foo', 'index', []]],
];
}
    /**
     * @dataProvider filterProvider
     * @param $url
     * @param $expected
     */
    public function testFilter($url, $expected)
    {
        self::assertEquals($expected, \MyApp\Router::filter($url));
    }

    public function filterProvider()
    {
        return [
            ['/catalog///123///234/222///', 'catalog/123/234/222'],
            ['catalog', 'catalog'],
            ['', ''],
            ['/', '']
        ];
    }
}