<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\UserController as Controller;
use App\Http\Middleware\Authenticate;

class TransactionController extends Controller
{
    protected $nameDataService = 'App\ServiceData\User\Transaction';
    protected $requiredFilterFields = [];
    protected $orders = [
        'createdAt'         => 'transactions.created_at',
        'id'                => 'transactions.id',
        'description'       => 'transactions.description',
        'amount'            => 'amount',
        'number'    => 'accounts.number',
        'statusChangedAt'         => [
            'requests.status_changed_at',
            'transactions.id'
        ],
    ];

    public function getFilters()
    {
        $filters =['user_id' => Authenticate::getLoginUserId()];

        $requestFilters = $this->getRequest()->get('filters');

        if(!empty($requestFilters['dateFrom']))
            $filters['date_from'] = date(DATE_ATOM, strtotime($requestFilters['dateFrom']));

        if(!empty($requestFilters['dateTo']))
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));

        if(empty($requestFilters['status']))
            $filters['status'] = 'executed';

        return $filters;
    }
}
