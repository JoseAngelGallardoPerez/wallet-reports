<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.02.2019
 * Time: 1:13
 */

namespace App\Http\Responses\Errors;


class NotFound extends Error
{
    protected $code = 'NOT_FOUND';
    protected $status = 400;
}