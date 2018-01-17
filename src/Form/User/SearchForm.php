<?php

namespace App\Form\User;

use App\Form\FormAbstract;

/**
 * @see https://github.com/symlex/input-validation
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
