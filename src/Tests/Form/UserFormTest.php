<?php

namespace App\Tests\Form;

use TestTools\TestCase\UnitTestCase;

class UserFormTest extends UnitTestCase
{
    /**
     * @var \App\Form\UserForm
     */
    protected $form;

    public function setUp()
    {
        $this->form = $this->get('form.user');
    }

    public function testValidForm()
    {
        $inputValues = array(
            'firstname' => 'Jens',
            'lastname' => 'Mander',
            'email' => 'test@example.com',
            'admin' => true
        );

        $this->form->setDefinedWritableValues($inputValues);

        $this->form->validate();

        $this->assertFalse($this->form->hasErrors());
        $this->assertCount(0, $this->form->getErrors());
    }

    public function testInvalidForm()
    {
        $inputValues = array(
            'firstname' => '',
            'lastname' => '',
            'email' => 'testexample.com',
            'admin' => ''
        );

        $this->form->setDefinedWritableValues($inputValues);

        $this->form->validate();

        $this->assertTrue($this->form->hasErrors());

        $this->assertCount(3, $this->form->getErrors());
    }
}