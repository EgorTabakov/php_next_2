<?php

namespace MyApp\Controllers;

use MyApp\Auth;
use MyApp\Models\Orders;
use MyApp\Models\Users;

class AdminController extends Controller
{
    /**
     * /admin
     */
    public function actionIndex()
    {
        if (!Auth::hasRole(Users::ROLE_ADMIN) && !Auth::hasRole(Users::ROLE_CONTENT)) {
            $this->redirect('/login');
        }

        if (isset($_GET['status']) && Auth::hasRole(Users::ROLE_ADMIN)) {
            Orders::setStatus($_GET['id'], $_GET['status']);
            exit;
        }

        $this->render('admin/index.twig', [
            'orders' => Orders::getAll(),
            'statuses' => Orders::getStatuses(),
            'allowEdit' => Auth::hasRole(Users::ROLE_ADMIN),
        ]);
    }
}