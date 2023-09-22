<?php

namespace Book\Controller;

use Base\Controller\BaseController;

class BookController extends BaseController 
{
    public function indexAction()
    {
        $cache = $this->getServiceManager()->get('cacheApc');
        $cache->flush();
        
        echo "Hello World!";
        exit;
    }
}