<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.02.2019
 * Time: 1:13
 */

namespace App\Http\Responses\Errors;


class Unauthorized extends Error
{
    protected $code = 'UNAUTHORIZED';
    protected $status = 401;
}