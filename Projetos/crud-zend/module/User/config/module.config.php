<?php
namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

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
                                'token' => '[a-f0-9]{32}$'
                            ]
                        ]
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'user/index/confirmated-email' => __DIR__.'/../view/user/index/confirmated-email.phtml',
            'user/index/new-password' => __DIR__.'/../view/user/index/new-password.phtml',
            'user/index/recovered-password' => __DIR__.'/../view/user/index/recovered-password.phtml',
            'user/index/register' => __DIR__.'/../view/user/index/register.phtml'
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ]
    ]
];
