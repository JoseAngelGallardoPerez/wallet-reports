<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ControllerInterface;

class TransactionController extends UserController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\User\Transaction';

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters', []);
        $filters = [];

        if(!empty($requestFilters['userId']))
            $filters['user_id'] = $requestFilters['userId'];

        if(!empty($requestFilters['dateFrom']))
            $filters['date_from'] = date(DATE_ATOM, strtotime($requestFilters['dateFrom']));

        if(!empty($requestFilters['dateTo']))
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));

        if(empty($requestFilters['status']))
            $filters['status'] = 'executed';

        return $filters;
    }
}
