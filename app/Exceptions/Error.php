<?php

namespace App\Exceptions;

class Error extends \Error
{
    protected $title = '';

    public function getTitle()
    {
        return $this->title;
    }

    public function getMess()
    {
        return parent::getMessage();
    }
}
