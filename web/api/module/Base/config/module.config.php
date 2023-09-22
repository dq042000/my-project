<?php

namespace Base;

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