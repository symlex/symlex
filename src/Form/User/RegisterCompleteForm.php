<?php

namespace App\Form\User;

use App\Form\FormAbstract;

/**
 * @see http://docs.symlex.org/en/latest/input-validation/
 */
class RegisterCompleteForm extends FormAbstract
{
    protected function init(array $params = array())
    {
        $definition = [
            'userFirstName' => [
                'caption' => 'First Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'hidden' => true,
                'readonly' => true,
            ],
            'userLastName' => [
                'caption' => 'Last Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'hidden' => true,
                'readonly' => true,
            ],
            'userEmail' => [
                'caption' => 'E-mail',
                'type' => 'email',
                'max' => 127,
                'hidden' => false,
                'readonly' => true,
            ],
            'password' => [
                'caption' => 'Password',
                'type' => 'string',
                'min' => 8,
                'password' => true,
                'required' => true,
            ],
            'passwordAgain' => [
                'caption' => 'Password Confirmation',
                'type' => 'string',
                'required' => true,
                'password' => true,
                'matches' => 'password'
            ]
        ];

        $this->setDefinition($definition);
    }
}
