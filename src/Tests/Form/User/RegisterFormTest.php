<?php

namespace App\Tests\Form\User;

use App\Form\User\RegisterForm;
use App\Service\Captcha;
use TestTools\TestCase\UnitTestCase;

class RegisterFormTest extends UnitTestCase
{
    /** @var RegisterForm */
    protected $form;

    /** @var Captcha */
    protected $captcha;

    public function setUp(): void
    {
        $container = $this->getContainer();

        $this->captcha = $container->get('service.captcha');

        $params = array(
            'captcha' => $this->captcha
        );

        $this->form = $container->get('form.factory')->create('User\Register', $params);
    }

    public function testValidForm()
    {
        $this->form->initCaptcha();

        $inputValues = array(
            'userFirstName' => 'Jens',
            'userLastName' => 'Mander',
            'userEmail' => 'test@example.com',
            'userNewsletter' => false,
            'captchaToken' => $this->captcha->getToken(),
            'captchaPhrase' => $this->captcha->getPhrase(),
        );

        $this->form->setDefinedWritableValues($inputValues);

        $this->form->validate();

        $this->assertFalse($this->form->hasErrors());
        $this->assertCount(0, $this->form->getErrors());
    }

    public function testInvalidForm()
    {
        $this->form->initCaptcha();

        $inputValues = array(
            'userFirstName' => '',
            'userLastName' => '',
            'userEmail' => 'testexample.com',
            'userNewsletter' => false,
            'captchaToken' => '',
            'captchaPhrase' => '',
        );

        $this->form->setDefinedWritableValues($inputValues);

        $this->form->validate();

        $this->assertTrue($this->form->hasErrors());

        $this->assertCount(5, $this->form->getErrors());
    }
}