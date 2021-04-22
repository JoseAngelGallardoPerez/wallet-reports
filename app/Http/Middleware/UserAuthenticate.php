<?php

namespace App\Http\Middleware;

class UserAuthenticate extends Authenticate
{
    protected $permission = '';
}
