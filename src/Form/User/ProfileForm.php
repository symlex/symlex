<?php

namespace App\Form\User;

use App\Form\FormAbstract;

/**
 * @see https://github.com/symlex/input-validation
 */
class ProfileForm extends FormAbstract
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
            ],
            'userLastName' => [
                'caption' => 'Last Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'required' => true,
            ],
            'userEmail' => [
                'caption' => 'E-mail',
                'type' => 'email',
                'max' => 127,
                'required' => true,
            ],
            'userNewsletter' => [
                'caption' => 'Receive newsletter and other occasional updates',
                'type' => 'bool',
                'required' => false,
            ]
       ];

        $this->setDefinition($definition);
    }
}
