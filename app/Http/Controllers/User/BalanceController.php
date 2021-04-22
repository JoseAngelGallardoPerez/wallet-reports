<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\UserController as Controller;
use App\Http\Middleware\Authenticate;

class BalanceController extends Controller
{
    protected $nameDataService = 'App\ServiceData\User\Balance';
    protected $requiredFilterFields = [];

    public function getFilters()
    {
        $filters =['user_id' => Authenticate::getLoginUserId()];

        return $filters;
    }
}
