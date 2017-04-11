<?php

namespace App\Controller\Rest;

use App\Exception\AccessDeniedException;
use App\Exception\FormInvalidException;
use App\Exception\UnauthorizedException;
use App\Exception\InvalidArgumentException;
use App\Form\UserForm;
use App\Service\Mail;
use App\Service\Session;
use App\Model\User;
use InputValidation\Form\Factory;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see https://github.com/lastzero/symlex#rest
 */
class UsersController
{
    protected $session;
    protected $user;
    protected $formFactory;
    protected $mail;

    public function __construct(Session $session, User $user, Factory $formFactory, Mail $mail)
    {
        $this->session = $session;
        $this->user = $user;
        $this->formFactory = $formFactory;
        $this->mail = $mail;

        if (!$this->session->isUser()) {
            throw new UnauthorizedException ('Please login or sign up to continue');
        }
    }

    public function createForm()
    {
        return $this->formFactory->create('User');
    }

    protected function sanitizeUserValues($values)
    {
        // Only return these fields if user is admin
        if (!$this->session->isAdmin()) {
            unset($values['created']);
            unset($values['updated']);
            unset($values['admin']);

            if($this->session->getUserId() != $values['user_id']) {
                unset($values['email']);
            }
        }

        return $values;
    }

    public function cgetAction()
    {
        $users = $this->user->findAll();
        $result = array();

        foreach ($users as $user) {
            $result[] = $this->sanitizeUserValues($user->getValues());
        }

        return $result;
    }

    public function getAction($id)
    {
        $this->user->find($id);

        $result = $this->sanitizeUserValues($this->user->getValues());

        return $result;
    }

    public function optionsAction($id, Request $request)
    {
        $form = $this->createForm();

        // Only load data for existing users
        if ($id != 'new') {
            $this->user->find($id);
            $form->setDefinedValues($this->user->getValues());
        }

        $result = $form->getAsArray();

        return $result;
    }

    public function deleteAction($id)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Users can not delete users');
        }

        $this->user->find($id)->delete();
    }

    public function putAction($id, Request $request)
    {
        if (!$this->session->isAdmin() && $id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        $this->user->find($id);

        $form = $this->createForm();

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        } else {
            $this->user->update($form->getValues());
        }

        return $this->sanitizeUserValues($this->user->getValues());
    }

    public function postAction(Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Users can not create new users');
        }

        $form = $this->createForm();

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        } else {
            $this->user->transactional(function () use ($form) {
                $this->user->save($form->getValues());
                $this->mail->newUser($this->user);
            });
        }

        return $this->sanitizeUserValues($this->user->getValues());
    }

    public function putPasswordAction($id, Request $request)
    {
        if ($id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        $this->user->find($id);

        $password = $request->get('password');
        $new_password = $request->get('new_password');

        if ($this->user->passwordIsValid($this->user->password, $password)) {
            $this->user->updatePassword($new_password);
        } else {
            throw new InvalidArgumentException('Old password is invalid');
        }
    }

}