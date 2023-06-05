<?php

declare (strict_types = 1);

namespace Base;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
    'laminas-cli' => [
        'commands' => [
            'base:install [re-create-database]' => Command\Install::class,
        ],
    ],
];
