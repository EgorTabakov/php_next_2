<?php

namespace MyApp\Controllers;

class IndexController extends Controller
{
    /**
     * /
     */
    public function actionIndex()
    {
        $this->render('index.twig');
    }

    /**
     * On nonexistent url
     */
    public function actionError()
    {
        $this->render('error.twig');
    }
}
