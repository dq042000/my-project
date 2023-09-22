<?php

namespace Base\Factory;

use Laminas\Cache\Service\StorageAdapterFactoryInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class CacheApcFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return \Laminas\Cache\Storage\PluginAwareInterface|\Laminas\Cache\Storage\StorageInterface|\Laminas\EventManager\EventsCapableInterface|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var StorageAdapterFactoryInterface $storageFactory */
        $storageFactory = $container->get(StorageAdapterFactoryInterface::class);
        return $storageFactory->create(
            'apcu',
            ['ttl' => 3600],
            [
                [
                    'name' => 'exception_handler',
                    'options' => [
                        'throw_exceptions' => false,
                    ],
                ],
            ]
        );
    }
}
