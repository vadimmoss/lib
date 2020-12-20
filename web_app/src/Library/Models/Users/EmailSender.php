<?php


namespace Library\Models\Users;


class MailSender
{
    public static function send(
        User $user,
        string $theme,
        string $template,
        array $vars = []
    ): void {
        extract($vars);
        ob_start();
        require 'templates/mail/' . $template;
        $messageText = ob_get_contents();
        ob_end_clean();

        mail($user->getEmail(), $theme, $messageText, 'Content-Type: text/html; charset=UTF-8');
    }
}