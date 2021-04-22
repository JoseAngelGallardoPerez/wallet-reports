<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.02.2019
 * Time: 1:13
 */

namespace App\Http\Responses\Errors;


class Params extends Error
{
    protected $code = 'BAD_COLLECTION_PARAMS';
    protected $status = 404;
}
