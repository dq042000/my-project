<?php

namespace Base\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Psr\Container\ContainerInterface;

class BaseController extends AbstractActionController
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function __construct(ContainerInterface $container)
    {
        $this->serviceManager = $container;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}