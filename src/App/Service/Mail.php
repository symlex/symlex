<?php

namespace App\Service;

use App\Model\User;
use Swift_Mailer;
use Swift_Message as Message;
use Twig_Environment;

class Mail
{
    protected $mailer;
    protected $twig;
    protected $from;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig, $from)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->from = $from;
    }

    public function createNewMessage($subject, array $recipients, $templateName, array $values = array())
    {
        $body = $this->twig->render('email/' . $templateName . '.twig', $values);

        $message = Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($recipients)
            ->setBody($body);

        return $message;
    }

    protected function getRandomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }

    public function passwordReset(User $user)
    {
        $token = $user->getPasswordResetToken();

        $values = array(
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'admin' => $user->admin,
            'token' => $token
        );

        $message = $this->createNewMessage('Password Reset', array($user->email), 'password', $values);

        $this->mailer->send($message);
    }

    public function newUser(User $user)
    {
        $token = $user->getPasswordResetToken();

        $values = array(
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'admin' => $user->admin,
            'token' => $token
        );

        $message = $this->createNewMessage('Welcome', array($user->email), 'new_user', $values);

        $this->mailer->send($message);
    }
}