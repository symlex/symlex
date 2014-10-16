<?php

namespace App\Form;

class UserForm extends Form {
    protected function init(array $params = array())
    {
        $definition = array(
            'firstname' => array('caption' => 'First Name', 'required' => true, 'type' => 'string'),
            'lastname' => array('caption' => 'Last Name', 'required' => true, 'type' => 'string'),
            'email' => array('caption' => 'E-Mail', 'required' => true, 'type' => 'email'),
            'admin' => array('caption' => 'Admin', 'type' => 'bool', 'checkbox' => true)
        );

        $this->setDefinition($definition);
    }
}