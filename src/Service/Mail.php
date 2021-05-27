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
    protected $tokenGenerator;
    protected $from;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig, TokenGenerator $tokenGenerator, $from)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->tokenGenerator = $tokenGenerator;
        $this->from = $from;
    }

    public function createNewMessage($subject, array $recipients, string $templateName, array $values = array())
    {
        $body = $this->twig->render('email/' . $templateName . '.twig', $values);

        $message = Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($recipients)
            ->setBody($body);

        return $message;
    }

    public function passwordReset(User $user)
    {
        $token = $this->tokenGenerator->getMediumToken();
        $user->setPasswordResetToken($token);

        $values = array(
            'firstname' => $user->userFirstName,
            'lastname' => $user->userLastName,
            'email' => $user->userEmail,
            'token' => $token
        );

        $message = $this->createNewMessage('Password Reset', array($user->userEmail), 'password', $values);

        @$this->mailer->send($message);
    }

    public function newUser(User $user)
    {
        $token = $this->tokenGenerator->getMediumToken();
        $user->setVerificationToken($token);

        $values = array(
            'firstname' => $user->userFirstName,
            'lastname' => $user->userLastName,
            'email' => $user->userEmail,
            'token' => $token
        );

        $message = $this->createNewMessage('Welcome', array($user->userEmail), 'new_user', $values);

        @$this->mailer->send($message);
    }
}