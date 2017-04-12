<?php

namespace App\Tests\Form\User;

class CreateFormTest extends EditFormTest
{
    /**
     * @var \App\Form\User\CreateForm
     */
    protected $form;

    public function setUp()
    {
        $this->form = $this->get('form.factory')->create('User\Create');
    }
}