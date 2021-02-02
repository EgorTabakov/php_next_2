<?php


namespace MyApp;


use MyApp\Models\Users;

class Auth
{
    public static function getUser()
    {
       return $_SESSION['user_login'];
    }

    public static function login($login)
    {
        $_SESSION['user_login'] = Users::get($login);
    }

    public static function logout()
    {
        $_SESSION['user_login'] = null;
    }

}