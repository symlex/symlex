<?php

namespace App\Form;

class UserForm extends Form {
    protected function init(array $params = array())
    {
        $definition = array(
            'firstname' => array('caption' => 'First Name', 'type' => 'string'),
            'lastname' => array('caption' => 'Last Name', 'type' => 'string'),
            'email' => array('caption' => 'E-Mail', 'type' => 'email'),
            'admin' => array('caption' => 'Admin', 'type' => 'bool', 'checkbox' => true)
        );

        $this->setDefinition($definition);
    }
}