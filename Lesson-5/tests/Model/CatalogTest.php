<?php

namespace MyApp\Models;

class CatalogTest extends \BaseTest
{
    public function testGetCategoriesById()
    {
        $categories = Catalog::getCategories();
        $expected = array_shift($categories);
        $actual = Catalog::getCategoryById($expected['id']);

        self::assertEquals($expected, $actual);

    }

    public function testGetCategories()
    {

        $categories = Catalog::getCategories();
        self::assertNotEmpty($categories);

    }
}