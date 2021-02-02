<?php

namespace MyApp\Controllers;

use MyApp\App;
use MyApp\Auth;

abstract class Controller
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(App::getInstance()->getConfig()['templates']);
        $this->twig = new \Twig\Environment($loader);
    }

    protected function redirect($url = null)
    {
        if (null === $url) {
            $url = $_SERVER['REQUEST_URI'];
        }

        header('Location: ' . $url);
        exit;
    }

    protected function render($template, $data = [])
    {
        $data['_user'] = Auth::getUser();
        echo $this->twig->render($template, $data);

    }
}
