<?php

declare (strict_types = 1);

namespace Application\Controller;

use Base\Controller\BaseController;
use Laminas\View\Model\ViewModel;

class IndexController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
