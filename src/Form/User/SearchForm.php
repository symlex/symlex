<?php

namespace App\Form\User;

use App\Form\FormAbstract;

/**
 * @see http://docs.symlex.org/en/latest/input-validation/
 */
class SearchForm extends FormAbstract {
    protected function init(array $params = [])
    {
        $definition = [
            'userEmail' => [
                'type' => 'email',
                'hidden' => false,
                'readonly' => false,
                'optional' => true,
                'caption' => 'E-mail',
            ]
        ];

        $this->setDefinition($definition);
    }
}
