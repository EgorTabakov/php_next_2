<?php

namespace MyApp;

use MyApp\Controllers\IndexController;
use MyApp\Models\History;

class App
{
    private static $instance;
    private $config;
    private $db;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getDB(): DB
    {
        return $this->db;
    }

    public function init()
    {
        $this->db = new DB($this->config['db']);
    }

    public function run()
    {
        $this->init();

        session_start();

        $path = $_SERVER['REQUEST_URI'];

        $router = new Router($this->config['routing']);
        [$controllerName, $actionName, $param] = $router->parse($path);


        if ($user = Auth::getUser()) {
            History::add($user['user_id'], $path);
        }


        $controllerClass = 'MyApp\Controllers\\' . ucfirst($controllerName) . 'Controller';
        $methodName = 'action' . ucfirst($actionName);

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName($param);
                return;
            }
        }

        (new IndexController())->actionError();
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    private function __construct()
    {
    }
}
