<?php

declare (strict_types = 1);

namespace DataManagement;

use Base\Service\Factory\BaseFactory;
use Laminas\Router\Http\Segment;

return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'data-management' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/data-management[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DataManagementController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\DataManagementController::class => BaseFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
];
