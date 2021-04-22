<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.02.2019
 * Time: 1:12
 */

namespace App\Http\Responses\Errors;


class Forbidden extends Error
{
    protected $code = 'FORBIDDEN';
    protected $status = 403;
}