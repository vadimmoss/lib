<?php

namespace Library\Controllers;

use Library\Models\Users\User;
use Library\ServiceClasses\UsersAuthentication;
use Library\View\View;

abstract class MainAbstractController
{
    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthentication::getAccountByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVariables('user', $this->user);
    }
}