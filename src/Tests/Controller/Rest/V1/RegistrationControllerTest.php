<?php

namespace App\Tests\Controller\Rest\V1;

use App\Controller\Rest\V1\RegistrationController;
use App\Dao\DaoAbstract;
use App\Exception\DuplicateException;
use App\Service\Captcha;
use TestTools\TestCase\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;

class RegistrationControllerTest extends UnitTestCase
{
    /** @var RegistrationController */
    protected $controller;

    /** @var Captcha */
    protected $captcha;

    public function getController(): RegistrationController
    {
        $container = $this->getContainer();
        $this->captcha = $container->get('service.captcha');

        /** @var RegistrationController $result */
        $result = $container->get('controller.rest.v1.registration');

        return $result;
    }

    public function testOptionsAction()
    {
        $controller = $this->getController();

        $form = $controller->optionsAction('new');
        $this->assertArrayHasKey('userFirstName', $form);
        $this->assertArrayHasKey('userLastName', $form);
        $this->assertArrayHasKey('userEmail', $form);
    }

    public function testPostAction()
    {
        DaoAbstract::setDateTimeClassName('\TestTools\Util\FixedDateTime');

        $controller = $this->getController();

        $form = $controller->optionsAction('new');

        $params = array(
            'userFirstName' => 'Jens',
            'userLastName' => 'Mander',
            'userEmail' => 'admin@example.com',
            'userNewsletter' => false,
            'captchaToken' => $form['captchaToken']['value'],
            'captchaPhrase' => $this->captcha->getPhrase(),
        );

        $request = Request::create('https://localhost/api/v1/registration', 'POST', $params);
        $this->expectException(DuplicateException::class);
        $controller->postAction($request);
    }
}