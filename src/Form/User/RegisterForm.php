<?php

namespace App\Form\User;

use App\Form\FormAbstract;
use App\Service\Captcha;

/**
 * @see http://docs.symlex.org/en/latest/input-validation/
 */
class RegisterForm extends FormAbstract
{
    protected function init(array $params = array())
    {
        $definition = [
            'userFirstName' => [
                'caption' => 'First Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'required' => true,
                'tags' => ['user']
            ],
            'userLastName' => [
                'caption' => 'Last Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'required' => true,
                'tags' => ['user']
            ],
            'userEmail' => [
                'caption' => 'E-mail',
                'type' => 'email',
                'max' => 127,
                'required' => true,
                'tags' => ['user']
            ],
            'userRole' => [
                'caption' => 'Role',
                'type' => 'string',
                'default' => 'user',
                'readonly' => true,
                'hidden' => true,
                'required' => true,
                'options' => $this->options('roles'),
                'tags' => ['user']
            ],
            'captchaImage' => [
                'caption' => 'Captcha Image',
                'type' => 'string',
                'default' => '',
                'image' => true,
                'readonly' => true,
                'required' => false,
            ],
            'captchaToken' => [
                'caption' => 'Captcha Token',
                'type' => 'string',
                'default' => '',
                'hidden' => true,
                'required' => true,
            ],
            'captchaPhrase' => [
                'caption' => 'Captcha Phrase',
                'type' => 'string',
                'default' => '',
                'required' => true,
            ],
            'userNewsletter' => [
                'caption' => 'Receive newsletter and other occasional updates',
                'type' => 'bool',
                'required' => false,
                'tags' => ['user']
            ],
        ];

        $this->setDefinition($definition);
    }

    protected function getCaptcha(): Captcha {
        /** @var Captcha $captcha */
        $captcha = $this->getParam('captcha');

        return $captcha;
    }

    public function initCaptcha()
    {
        $captcha = $this->getCaptcha();

        $captcha->build();

        $this->captchaImage = $captcha->getInline();
        $this->captchaToken = $captcha->getToken();
        $this->captchaPhrase = '';
    }

    public function captchaIsValid()
    {
        return $this->getCaptcha()->isValid($this->captchaToken, $this->captchaPhrase);
    }

    public function captchaIsInvalid()
    {
        return !$this->captchaIsValid();
    }

    public function validate()
    {
        $result = parent::validate();

        if($this->captchaIsInvalid()) {
            $this->addError('captchaPhrase', 'form.captcha_not_valid');
        }

        return $result;
    }
}
