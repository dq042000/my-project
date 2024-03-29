<?php
namespace Blog\Factory;

use Blog\Model\LaminasDbSqlCommand;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LaminasDbSqlCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LaminasDbSqlCommand($container->get(AdapterInterface::class));
    }
}