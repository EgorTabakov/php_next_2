<?php
require 'connect.php';
require_once 'vendor\autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$limit = 5;

if (isset($_GET['from'])) {
    $count = DB::getInstance()->getCount(DB::TABLE_ITEMS);
    $loaded = $_GET['from'] + $limit;
    $all = $loaded >= $count;
    $items = DB::getInstance()->getLimitData(DB::TABLE_ITEMS, $_GET['from'], $limit);
    echo $twig->render('items.twig', [
        'items' => $items,
        'all' => $all,
    ]);
    exit();
}
$items = DB::getInstance()->getAllData(DB::TABLE_ITEMS);
echo $twig->render('index.twig', [
    'items' => $items,
    'limit' => $limit,
]);
