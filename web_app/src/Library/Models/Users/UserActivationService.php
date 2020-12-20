<?php


namespace Library\Models\Users;


use Library\ServiceClasses\Database;

class UserActivationService
{
    private const TABLE_NAME = 'users_activation_codes';

    public static function createActivationCode(User $user): string
    {
        // Генерируем случайную последовательность символов, о функциях почитайте в документации
        $code = bin2hex(random_bytes(16));

        $db = Database::getConnection();
        $db->sqlQuery(
            'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );

        return $code;
    }

    public static function checkActivationCode(User $user, string $code): bool
    {
        $db = Database::getConnection();
        $result = $db->sqlQuery(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );
        return !empty($result);
    }
}