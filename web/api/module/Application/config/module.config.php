<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ConfigAbstractFactory::class,
        ],
    ],
    ConfigAbstractFactory::class => [
        Controller\IndexController::class => [
            'default-cache',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
                'class' => 'nav-link',
            ],
            [
                'label' => 'Album',
                'route' => 'album',
                'class' => 'nav-link',
                'pages' => [
                    [
                        'label' => 'Add',
                        'route' => 'album',
                        'action' => 'add',
                    ],
                    [
                        'label' => 'Edit',
                        'route' => 'album',
                        'action' => 'edit',
                    ],
                    [
                        'label' => 'Delete',
                        'route' => 'album',
                        'action' => 'delete',
                    ],
                ],
            ],
            [
                'label' => 'Blog',
                'route' => 'blog',
                'class' => 'nav-link',
                'pages' => [
                    [
                        'label' => 'Add',
                        'route' => 'blog',
                        'action' => 'add',
                    ],
                    [
                        'label' => 'Edit',
                        'route' => 'blog',
                        'action' => 'edit',
                    ],
                    [
                        'label' => 'Delete',
                        'route' => 'blog',
                        'action' => 'delete',
                    ],
                ],
            ],
        ],
    ],
];
