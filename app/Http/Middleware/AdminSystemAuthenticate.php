<?php

namespace App\Http\Middleware;

class AdminSystemAuthenticate extends Authenticate
{
    protected $permission = 'view_general_system_reports';
}
