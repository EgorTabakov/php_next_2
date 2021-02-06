<?php

namespace MyApp\Controllers;

use MyApp\Auth;
use MyApp\Models\Admin;
use MyApp\Models\Basket;
use MyApp\Models\Goods;
use MyApp\Models\History;
use MyApp\Models\Orders;
use MyApp\Models\Users;

class AccountController extends Controller
{
    public function actionAdmin()
    {


        if (!($user = Auth::getUser())) {
            $this->redirect('login');
        }

        $orders = Admin::get();

        $this->render('account/admin.twig', [
            'orders' => $orders,
        ]);
    }

    public function actionOrder()
    {
        $basket = Basket::get();

        if (!$basket['count']) {
            $this->redirect('/catalog');
        }

        if (!($user = Auth::getUser())) {
            $this->redirect('login');
        }

        $orderId = Orders::add($user['user_id'], $basket['goods']);

        Basket::clear();
        $this->render('account/order.twig', [
            'orderId' => $orderId,

        ]);
    }

    public function actionBasket()
    {
        $basket = Basket::get();

        $goods = [];
        $sum = 0;
        foreach ($basket['goods'] as $id => $count) {
            $good = Goods::getById($id);
            $good['count'] = $count;
            $sum += $good['sum'] = $count * $good['price'];
            $goods[] = $good;
        }

        $this->render('account/basket.twig', [
            'sum' => $sum,
            'goods' => $goods,
        ]);
    }

    /**
     * /account
     */
    public function actionIndex()
    {
        if (!($user = Auth::getUser())) {
            $this->redirect('/login');
        }
        $history = History::getLast($user['user_id']);
        $this->render('account/index.twig', [
            'history' => $history,
        ]);
    }

    /**
     * /account/add
     */
    public function actionAddUser()
    {
        $error = null;
        if (!empty($_POST['login'])) {
            if (!empty($_POST['password'])) {
                Users::addUser($_POST['login'], $_POST['password']);
                $this->redirect();
            } else {
                $error = 2;
            }
        } else {
            $error = 1;
        }

        $this->render('account/addUser.twig', [
            'error' => $error,
        ]);
    }

    public function actionLogout()
    {
        Auth::logout();
        Basket::clear();
        $this->redirect('/');
    }

    /**
     * /account/login
     */
    public
    function actionLogin()
    {
        $error = false;
        if (isset($_POST['login'])) {
            if (Users::check($_POST['login'], $_POST['password'])) {
                Auth::login($_POST['login']);
                $this->redirect('/account');
            } else {
                $error = true;
            }
        }

        $this->render('account/login.twig', [
            'error' => $error,
        ]);

    }

    /**
     * /account/settings
     */
    public
    function actionSettings()
    {
        echo 'Users settings';
    }

    /**
     * /account/password
     */
    public
    function actionPassword()
    {
        echo 'Users change pwd page';
    }
}
