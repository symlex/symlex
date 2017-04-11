<?php

namespace App\Controller\Web;

use App\Service\Mail;
use App\Service\Session;
use App\Model\User;
use App\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see https://github.com/lastzero/symlex#controllers
 */
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
        return array('page_name' => 'Login');
    }

    public function postLoginAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $result = array('email' => $email, 'error' => '', 'page_name' => 'Login');

        try {
            $this->session->login($email, $password);
            return '/';
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    public function resetAction()
    {
        return array('email' => '', 'error' => false, 'success' => false, 'page_name' => 'Reset Password');
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
        $this->user->findByPasswordResetToken($token);

        return array('token' => $token, 'page_name' => 'Reset Password');
    }

    public function postPasswordAction($token, Request $request)
    {
        $error = false;

        try {
            $user = $this->user->findByPasswordResetToken($token);

            $password = $request->get('password');
            $password_confirm = $request->get('password_confirm');

            if ($password == $password_confirm) {
                $user->updatePassword($password);
                $user->deletePasswordResetToken();
                $this->session->logout();
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
        return '/';
    }
}