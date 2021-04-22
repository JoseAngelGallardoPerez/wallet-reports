<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.02.2019
 * Time: 1:13
 */

namespace App\Http\Responses\Errors;

use Throwable;

class BadRequest extends Error
{
    protected $code = 'BAD_REQUEST';
    protected $status = 400;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        if(env('ENV') == 'development'){
            //Log::useFiles('php://stdout', 'info');
        }
    }
}