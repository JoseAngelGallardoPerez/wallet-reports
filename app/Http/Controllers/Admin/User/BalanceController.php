<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ControllerInterface;

class BalanceController extends UserController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\User\Balance';
    protected $requiredFilterFields = ['userId'];

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters');

        $filters =['user_id' => $requestFilters['userId']];

        return $filters;
    }
}
