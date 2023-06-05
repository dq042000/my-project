<?php

declare (strict_types = 1);

namespace Base\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager as ServiceManagerAlias;
use Psr\Container\ContainerInterface;
use Doctrine\Orm\EntityManager as EntityManagerAlias;

class BaseController extends AbstractActionController
{
    /** @var ServiceManagerAlias */
    private $serviceManager;

    /** @var EntityManagerAlias */
    protected $_em;

    public function __construct(ContainerInterface $container)
    {
        $this->serviceManager = $container;
        $this->_em = $container->get('doctrine.entitymanager.orm_default');
    }

    public function getServiceManager(): ServiceManagerAlias
    {
        return $this->serviceManager;
    }

    /**
     * @return EntityManagerAlias|mixed
     */
    public function getEntityManager()
    {
        return $this->_em;
    }
}
