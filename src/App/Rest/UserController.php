<?php

namespace App\Rest;

use App\Exception\AccessDeniedException;
use App\Exception\FormInvalidException;
use App\Exception\UnauthorizedException;
use App\Form\UserForm;
use App\Model\Session;
use App\Model\User;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    protected $session;
    protected $user;
    protected $form;

    public function __construct(Session $session, User $user, UserForm $form)
    {
        $this->session = $session;
        $this->user = $user;
        $this->form = $form;

        if (!$this->session->isUser()) {
            throw new UnauthorizedException ('Please login or signup to continue');
        }
    }

    protected function sanitizeUserValues($values)
    {
        // Never return passwords
        unset($values['password']);

        // Only return these fields if user is admin
        if (!$this->session->isAdmin()) {
            unset($values['created']);
            unset($values['updated']);
            unset($values['email']);
            unset($values['admin']);
        }

        return $values;
    }

    public function cgetAction()
    {
        $users = $this->user->findAll();
        $result = array();

        foreach($users as $user) {
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
        $this->form->setDefinedWritableValues($request->request->all())->validate();

        if($this->form->hasErrors()) {
            throw new FormInvalidException($this->form->getFirstError());
        } else {
            $this->user->update($this->form->getValues());
        }

        return $this->sanitizeUserValues($this->user->getValues());
    }

    public function postAction(Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Users can not create new users');
        }

        $this->form->setDefinedWritableValues($request->request->all())->validate();

        if($this->form->hasErrors()) {
            throw new FormInvalidException($this->form->getFirstError());
        } else {
            $this->user->create($this->form->getValues());
        }

        return $this->sanitizeUserValues($this->user->getValues());
    }
}