<?php

namespace Library\Models\Users;

use Library\Exceptions\InvalidRowException;
use Library\Models\ActiveRecordEngine;
use Library\ServiceClasses\Database;

class User extends ActiveRecordEngine
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    protected $age;

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public  function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->authToken;
    }

    protected static function getTable(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidRowException('Please input Nickname');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidRowException('Only latin literals');
        }

        if (empty($userData['email'])) {
            throw new InvalidRowException('Please input E-mail');
        }

        if (empty($userData['age'])) {
            throw new InvalidRowException('Please input age');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidRowException('Incorrect Email');
        }

        if (empty($userData['password'])) {
            throw new InvalidRowException('Please input password');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidRowException('8 characters');
        }
        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidRowException('nickname is already exist');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidRowException('Email is already exist');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->age = $userData['age'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }
    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidRowException('Please input E-mail');
        }

        if (empty($loginData['password'])) {
            throw new InvalidRowException('Please input password');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidRowException('User with this email is not exist');
        }

        if (!password_verify($loginData['password'], $user->getPassHash())) {
            throw new InvalidRowException('Incorrect password');
        }

        if (!$user->isConfirmed) {
            throw new InvalidRowException('User is not confirmed');
        }

        $user->refreshToken();
        $user->save();

        return $user;
    }

    public function getPassHash(): string
    {
        return $this->passwordHash;
    }

    public function refreshToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public function isUserAdmin(): bool {
        if($this->role == 'admin'){
            return true;
        }
        else return false;
    }

    public function getCountDownloads(): int{
        $idUser = $this->getId();
        $db = Database::getConnection();
        $result = $db->simplesqlQuery('SELECT COUNT(*) FROM `downloads` WHERE `id_downloader` = '. $idUser .' ');
        return $result;
    }
    public function getCountViews(): int{
        $idUser = $this->getId();
        $db = Database::getConnection();
        $result = $db->simplesqlQuery('SELECT COUNT(*) FROM `views` WHERE `id_viewer` = '. $idUser .' ');
        return $result;
    }

}

