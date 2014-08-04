<?php

namespace App\Controller;

use App\Model\Mail;
use App\Model\Session;
use App\Model\User;
use App\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class AuthController
{
    protected $session;
    protected $user;

    public function __construct(Session $session, User $user, Mail $mail)
    {
        $this->session = $session;
        $this->user = $user;
        $this->mail = $mail;
    }

    public function loginAction()
    {
    }

    public function resetAction()
    {
        return array('email' => '', 'error' => false, 'success' => false);
    }

    public function postResetAction(Request $request)
    {
        $error = false;
        $success = false;
        $email = $request->get('email');

        try {

            $user = $this->user->findByEmail($email);

            $this->mail->passwordReset($user);

            $success = true;
        } catch(InvalidArgumentException $e) {
            $error = $e->getMessage();
        }

        return array('email' => $email, 'error' => $error, 'success' => $success);
    }

    public function passwordAction($token)
    {
        $this->session->logout();

        $this->user->findByPasswordResetToken($token);

        return array('token' => $token);
    }

    public function postPasswordAction($token, Request $request)
    {
        $error = false;

        $this->session->logout();

        try {
            $user = $this->user->findByPasswordResetToken($token);

            $password = $request->get('password');
            $password_confirm = $request->get('password_confirm');

            if ($password == $password_confirm) {
                $user->updatePassword($password);
                $user->deletePasswordResetToken();
                return '/auth/login';
            } else {
                $error = 'Passwords do not match';
            }
        } catch(InvalidArgumentException $e) {
            $error = $e->getMessage();
        }

        return array('token' => $token, 'error' => $error);
    }

    public function logoutAction()
    {
        $this->session->logout();
        return '/index/index';
    }

    public function postLoginAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $result = array('email' => $email, 'password' => $password, 'error' => '');

        try {
            $this->session->login($email, $password);
            return '/index/index';
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }
}