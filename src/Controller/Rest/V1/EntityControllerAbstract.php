<?php

namespace App\Controller\Rest\V1;

use App\Exception\FormInvalidException;
use App\Exception\UnauthorizedException;
use App\Model\ModelFactory;
use App\Service\Session;
use App\Form\FormFactory;
use InputValidation\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see https://docs.symlex.org/en/latest/framework/rest/
 */
class EntityControllerAbstract
{
    protected string $modelName = '';
    protected string $searchFormName = '';
    protected string $createFormName = '';
    protected string $editFormName = '';

    protected $session;
    protected $modelFactory;
    protected $formFactory;
    protected $model;

    public function __construct(Session $session, ModelFactory $modelFactory, FormFactory $formFactory)
    {
        $this->session = $session;
        $this->modelFactory = $modelFactory;
        $this->formFactory = $formFactory;
        $this->model = $this->createModel($this->modelName);

        if (!$this->session->isUser()) {
            throw new UnauthorizedException ('Authentication required, please login');
        }
    }

    protected function createForm(string $name)
    {
        $params = array(
            'session' => $this->session
        );

        return $this->formFactory->create($name, $params);
    }

    /**
     * @param $name
     * @return \App\Model\ModelAbstract
     */
    protected function createModel(string $name)
    {
        return $this->modelFactory->create($name);
    }

    public function cgetAction(Request $request)
    {
        $form = $this->createForm($this->searchFormName)->setDefinedWritableValues($request->query->all())->validate();

        return $this->search($form, $request);
    }

    protected function search(Form $form, Request $request)
    {
        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        }

        $options = array(
            'count' => (int)$request->query->get('count', 50),
            'offset' => (int)$request->query->get('offset', 0),
            'order' => (string)$request->query->get('order', '')
        );

        return $this->model->search($form->getValues(), $options);
    }

    public function getAction($id)
    {
        return $this->model->find($id)->getValues();
    }

    public function coptionsAction()
    {
        $form = $this->createForm($this->searchFormName);

        return $form->getAsArray();
    }

    public function optionsAction($id, Request $request)
    {
        // Only load data for existing users
        if ($id == 'new') {
            $form = $this->createForm($this->createFormName);
        } else {
            $form = $this->createForm($this->editFormName);
            $this->model->find($id);
            $form->setDefinedValues($this->model->getValues());
        }

        return $form->getAsArray();
    }

    public function deleteAction($id)
    {
        $this->model->find($id)->delete();
    }

    public function putAction($id, Request $request)
    {
        $this->model->find($id);

        $form = $this->createForm($this->editFormName);

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        }

        $this->model->update($form->getValues());

        return $this->model->getValues();
    }

    public function postAction(Request $request)
    {
        $form = $this->createForm($this->createFormName);

        $form->setDefinedWritableValues($request->request->all())->validate();

        if ($form->hasErrors()) {
            throw new FormInvalidException($form->getFirstError());
        }

        $this->model->save($form->getValues());

        return $this->model->getValues();
    }
}
