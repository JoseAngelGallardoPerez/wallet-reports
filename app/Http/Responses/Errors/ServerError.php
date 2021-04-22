<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.02.2019
 * Time: 1:13
 */

namespace App\Http\Responses\Errors;


class ServerError extends Error
{
    protected $code = 'INTERNAL_SERVER_ERROR';
    protected $status = 500;
}