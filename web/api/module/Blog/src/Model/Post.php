<?php

namespace Blog\Model;

class Post
{
    private $id;
    private $text;
    private $title;

    public function __construct($title, $text, $id = null)
    {
        $this->text = $text;
        $this->title = $title;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getTitle()
    {
        return $this->title;
    }
}