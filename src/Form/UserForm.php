<?php

namespace App\Form;

/**
 * @see https://github.com/symlex/input-validation
 */
class UserForm extends FormAbstract {
    protected function init(array $params = array())
    {
        $definition = array(
            'firstname' => array(
                'caption' => 'First Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'required' => true,
            ),
            'lastname' => array(
                'caption' => 'Last Name',
                'type' => 'string',
                'min' => 2,
                'max' => 64,
                'required' => true,
            ),
            'email' => array(
                'caption' => 'E-Mail',
                'type' => 'email',
                'max' => 127,
                'required' => true,
            ),
            'admin' => array(
                'caption' => 'Admin',
                'type' => 'bool',
                'optional' => true,
            ),
        );

        $this->setDefinition($definition);
    }
}