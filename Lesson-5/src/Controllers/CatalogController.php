<?php


namespace MyApp\Controllers;


use MyApp\Models\Basket;
use MyApp\Models\Catalog;
use MyApp\Models\Goods;

class CatalogController extends Controller
{

    public function actionIndex()
    {
        $this->render('catalog/index.twig', [
            'categories' => Catalog::getCategories(),
        ]);
    }

    public function actionCategory($params)
    {
        $catId = array_shift($params);
        if (!($category = Catalog::getCategoryById($catId))) {
            $this->redirect('/catalog');
        }
        $this->render('/catalog/category.twig', [
            'category' => $category,
            'goods' => Goods::getByCategory($catId),
        ]);
    }

    public function actionGood($param)
    {
        if (isset($_GET['add'])) {
            Basket::add($_GET['add']);
        }

        [$catId, $goodId] = $param;

        if (!($category = Catalog::getCategoryById($catId))) {
            $this->redirect('/catalog');
        }

        if (!($good = Goods::getById($goodId))) {
            $this->redirect('/catalog');
        }
        $images = Goods::getImageById($goodId);


        $this->render('/catalog/good.twig', [
            'category' => $category,
            'good' => $good,
            'images' => Goods::getImageById($goodId),
        ]);

    }
}