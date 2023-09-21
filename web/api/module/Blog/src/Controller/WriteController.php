<?php
namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\PostCommandInterface;
use Laminas\Mvc\Controller\AbstractActionController;

class WriteController extends AbstractActionController
{
    /**
     * @var PostCommandInterface
     */
    private $command;

    /**
     * @var PostForm
     */
    private $form;

    /**
     * @param PostCommandInterface $command
     * @param PostForm $form
     */
    public function __construct(PostCommandInterface $command, PostForm $form)
    {
        $this->command = $command;
        $this->form = $form;
    }

    public function addAction()
    {
    }
}