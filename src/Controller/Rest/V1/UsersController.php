<?php

namespace App\Controller\Rest\V1;

use App\Exception\AccessDeniedException;
use App\Exception\Exception;
use App\Exception\FormInvalidException;
use App\Exception\InvalidArgumentException;
use App\Model\User;
use App\Service\Mail;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see https://docs.symlex.org/en/latest/framework/rest/
 */
class UsersController extends EntityControllerAbstract
{
    protected string $modelName = 'User';
    protected string $searchFormName = 'User\Search';
    protected string $createFormName = 'User\Create';
    protected string $editFormName = 'User\Edit';
    protected $mail;

    public function setMailService(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function getMailService(): Mail
    {
        if(!$this->mail) {
            throw new Exception('Mail service not set');
        }

        return $this->mail;
    }

    public function cgetAction(Request $request)
    : array {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException("You don't have permission to query this service");
        }

        $form = $this->createForm($this->searchFormName)->setDefinedWritableValues($request->query->all())->validate();

        return $this->search($form, $request);
    }

    public function optionsAction($id, Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException("You don't have permission to query this service");
        }

        return parent::optionsAction($id, $request);
    }

    public function deleteAction($id)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Users can not delete users');
        }

        parent::deleteAction($id);
    }

    public function putAction($id, Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('User ID does not match');
        }

        return parent::putAction($id, $request);
    }

    public function postAction(Request $request)
    {
        if (!$this->session->isAdmin()) {
            throw new AccessDeniedException('Users can not create new users');
        }

        $result = parent::postAction($request);

        /** @var User $model */
        $model = $this->model;

        $this->getMailService()->newUser($model);

        return $result;
    }

    public function cputPasswordAction($id, Request $request)
    {
        if ($id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        /** @var User $model */
        $model = $this->model;

        $model->find($id);

        $password = $request->get('password');
        $new_password = $request->get('new_password');

        if (!$model->passwordIsValid($password)) {
            throw new InvalidArgumentException('Old password is invalid');
        }

        $model->updatePassword($new_password);
    }

    public function coptionsProfileAction($id)
    {
        if ($id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        $form = $this->createForm('User\Profile');
        $this->model->find($id);
        $form->setDefinedValues($this->model->getValues());

        return $form->getAsArray();
    }

    public function postProfileAction($id, Request $request)
    {
        if ($id != $this->session->getUserId()) {
            throw new AccessDeniedException('User ID does not match');
        }

        $this->model->find($id);

        $form = $this->createForm('User\Profile');

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        }

        $this->model->update($form->getValues());

        return $this->model->getValues();
    }
}
