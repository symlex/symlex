<?php

namespace App\Tests\Form\User;

use TestTools\TestCase\UnitTestCase;

class EditFormTest extends UnitTestCase
{
    /**
     * @var \App\Form\User\EditForm
     */
    protected $form;

    public function setUp(): void
    {
        $this->form = $this->get('form.factory')->create('User\Edit');
    }

    public function testValidForm()
    {
        $inputValues = array(
            'userFirstName' => 'Jens',
            'userLastName' => 'Mander',
            'userEmail' => 'test@example.com',
            'userRole' => 'admin',
            'userNewsletter' => false
        );

        $this->form->setDefinedWritableValues($inputValues);

        $this->form->validate();

        $this->assertFalse($this->form->hasErrors());
        $this->assertCount(0, $this->form->getErrors());
    }

    public function testInvalidForm()
    {
        $inputValues = array(
            'userFirstName' => '',
            'userLastName' => '',
            'userEmail' => 'testexample.com',
            'userRole' => 'admin',
            'userNewsletter' => false
        );

        $this->form->setDefinedWritableValues($inputValues);

        $this->form->validate();

        $this->assertTrue($this->form->hasErrors());

        $this->assertCount(3, $this->form->getErrors());
    }
}
