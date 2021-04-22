<?php

namespace App\Http\Middleware;

class AdminUserAuthenticate extends Authenticate
{
    protected $permission = 'view_user_reports';
}
