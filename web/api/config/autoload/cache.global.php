<?php

return [
    'caches' => [
        'default-cache' => [
            'adapter' => Laminas\Cache\Storage\Adapter\Filesystem::class,
            'options' => [
                'cache_dir' => __DIR__ . '/../../data/cache',
            ],
        ],
    ],
];