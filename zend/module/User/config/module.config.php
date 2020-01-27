<?php
namespace User;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' =>[
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'register'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' =>[
                    'default' => [
                        'type' => Segment::class,
                        'options' =>[
                            'route' => '[/:action][/token/:token]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'token' => '[[a-f0-9]{32}]$'
                            ]
                        ]
                    ]
                ]
            ],            
        ]
    ]
];