<?php

namespace MyApp\Controllers;

use MyApp\Auth;
use MyApp\Models\Goods;
use MyApp\Models\History;
use MyApp\Models\Users;

class AccountController extends Controller
{
    /**
     * /account
     */
    public function actionIndex()
    {
        if (!($user = Auth::getUser())) {
            $this->redirect('/account/login');
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

    public
    function actionLogout()
    {
        Auth::logout();
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
