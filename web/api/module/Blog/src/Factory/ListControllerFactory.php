<?php

namespace Blog\Factory;

use Blog\Controller\ListController;
use Blog\Model\PostRepositoryInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ListControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ListController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ListController($container->get(PostRepositoryInterface::class));
    }
}