<?php

use Core\Factories\FormElementErrorsFactory;
use Core\Factories\TransportSmtpFactory;
use \Zend\Form\View\Helper\FormElementErrors;
return [
    'service_manager' => [
        'factories' => [
            //Toda vez que precisar da classe, voce pode chamar pelo valor da String
            //Ou seja ao chamar essa String o Objeto ja sai pronto para uso, sem necessidade
            //de configurar.
            'core.transport.smtp' => TransportSmtpFactory::class
        ]
    ],
    'view_helpers' => [
        'factories' => [
            FormElementErrors::class => FormElementErrorsFactory::class
        ]
    ]

];
?>