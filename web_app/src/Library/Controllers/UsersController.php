<?php


namespace Library\Controllers;

use Library\Exceptions\ForbiddenException;
use Library\Exceptions\InvalidRowException;
use Library\Models\Users\MailSender;
use Library\Models\Users\User;
use Library\Models\Users\UserActivationService;
use Library\ServiceClasses\UsersAuthentication;
use Library\View\View;

class UsersController extends MainAbstractController
{

    public function signUp()
    {
        if (!empty($_POST))
        {
            try
            {
                $user = User::signUp($_POST);
            } catch (InvalidRowException $e)
            {
                $this->view->renderPageHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
            if ($user instanceof User)
            {
                $code = UserActivationService::createActivationCode($user);

                MailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderPageHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderPageHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {

        $user = User::getById($userId);
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            echo 'OK!';
        }
    }
    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthentication::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidRowException $e) {
                $this->view->renderPageHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderPageHtml('users/login.php');
    }

    public function logOut()
    {
        if($this->user){
            unset($this->user);
            UsersAuthentication::deleteToken();
        }
        header('Location: /');
    }

    public function view():void
    {
        if($this->user) {
            $userInfo = $this->user;
            $this->view->renderPageHtml('users/view.php',
                ['user' => $userInfo]
            );
        }
        else{
            throw new ForbiddenException();
        }
    }

}