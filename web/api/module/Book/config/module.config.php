<?php

namespace Book;

use Base\Factory\BaseFactory;
use Laminas\Router\Http\Literal;

return [
    'controllers' => [
        'factories' => [
            Controller\BookController::class => BaseFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'book' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/book',
                    'defaults' => [
                        'controller' => Controller\BookController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
];