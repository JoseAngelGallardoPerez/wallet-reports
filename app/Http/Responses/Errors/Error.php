<?php

namespace App\Http\Responses\Errors;

class Error extends \Error
{
    protected $code = '';
    protected $target = 'common';
    protected $status = 400;

    public function getErrorCode()
    {
        return $this->code;
    }

    public function getErrorMeta()
    {
        return [];
    }

    public function getErrorTarget()
    {
        return $this->target;
    }

    public function getErrorStatus()
    {
        return $this->status;
    }
}
