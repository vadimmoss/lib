<?php


namespace Library\ServiceClasses;
use Library\Models\Users\User;

class UsersAuthentication
{
    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    public static function deleteToken(): void{
        setcookie('token', '', time() - 3600, '/', '', false, true);
    }

    public static function getAccountByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int) $userId);

        if ($user === null) {
            return null;
        }

        if ($user->getToken() !== $authToken) {
            return null;
        }

        return $user;
    }
}