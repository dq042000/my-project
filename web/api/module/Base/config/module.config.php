<?php

namespace Base;

use Laminas\Router\Http\Literal;

return [
    'service_manager' => [
        'aliases' => [
            'cacheApc' => Factory\CacheApcFactory::class,
        ],
        'factories' => [
            Factory\CacheApcFactory::class => Factory\CacheApcFactory::class,
        ],
    ],
];