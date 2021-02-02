<?php

error_reporting(E_ALL & ~E_NOTICE);

require '../vendor/autoload.php';

\MyApp\App::getInstance()
    ->setConfig(require '../config/main.php')
    ->run();