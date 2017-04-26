<?php

namespace App\Controller\Rest;

use App\Exception\AccessDeniedException;
use App\Exception\FormInvalidException;
use App\Exception\UnauthorizedException;
use App\Exception\InvalidArgumentException;
use App\Service\Mail;
use App\Service\Session;
use App\Model\User;
use App\Form\FormFactory;
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

    public function __construct(Session $session, User $user, FormFactory $formFactory, Mail $mail)
    {
        $this->session = $session;
        $this->user = $user;
        $this->formFactory = $formFactory;
        $this->mail = $mail;

        if (!$this->session->isUser()) {
            throw new UnauthorizedException ('Please login or sign up to continue');
        }
    }

    public function createForm($name)
    {
        return $this->formFactory->create($name);
    }

    public function cgetAction(Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Only admins can query users');
        }

        $options = array(
            'count' => $request->query->get('count', 50),
            'offset' => $request->query->get('offset', 0)
        );

        $result = $this->user->search(array(), $options);

        return $result;
    }

    public function getAction($id)
    {
        if (!$this->session->isAdmin() && $id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        $result = $this->user->find($id)->getValues();

        return $result;
    }

    public function optionsAction($id, Request $request)
    {
        // Only load data for existing users
        if ($id == 'new') {
            $form = $this->createForm('User\Create');
        } else {
            $form = $this->createForm('User\Edit');
            $this->user->find($id);
            $form->setDefinedValues($this->user->getValues());
        }

        return $form->getAsArray();
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

        $form = $this->createForm('User\Edit');

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        }

        $this->user->update($form->getValues());

        return $this->user->getValues();
    }

    public function postAction(Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Users can not create new users');
        }

        $form = $this->createForm('User\Create');

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        }

        $this->user->transactional(function () use ($form) {
            $this->user->save($form->getValues());
            $this->mail->newUser($this->user);
        });

        return $this->user->getValues();
    }

    public function putPasswordAction($id, Request $request)
    {
        if ($id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        $this->user->find($id);

        $password = $request->get('password');
        $new_password = $request->get('new_password');

        if (!$this->user->passwordIsValid($this->user->password, $password)) {
            throw new InvalidArgumentException('Old password is invalid');
        }

        $this->user->updatePassword($new_password);
    }

}