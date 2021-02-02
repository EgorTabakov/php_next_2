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

    public function run()
    {
        session_start();
        $this->db = new DB($this->config['db']);

        // ex1: /cont/act/123?foo=bar
        // ex2: /cont/act/123
        $path = $_SERVER['REQUEST_URI'];
        // /cont/act/123/
        [$url] = explode('?', $path);
        // cont/act/123
        $url = trim($url, '/');
        [$controllerName, $actionName, $param] = explode('/', $url);

        if ($user = Auth::getUser()) {
            History::add($user['user_id'], $path);
        }

        if (empty($controllerName)) {
            $controllerName = 'index';
        }
        if (empty($actionName)) {
            $actionName = 'index';
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
