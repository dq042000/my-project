<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Cache\Storage\StorageInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function __construct(
        private readonly StorageInterface $cache
    ) {
        
    }

    public function indexAction()
    {
        if (! $this->cache->hasItem('example')) {
            $this->cache->setItem('example', 'example');
        }

        return new ViewModel();
    }
}
