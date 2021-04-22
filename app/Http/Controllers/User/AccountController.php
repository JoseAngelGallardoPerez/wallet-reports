<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\UserController as Controller;
use App\ServiceData\ServiceData;
use App\Http\Middleware\Authenticate;

class AccountController extends Controller
{
    protected $nameDataService = 'App\ServiceData\User\Account';
    protected $requiredFilterFields = ['accountId'];
    protected $orders = [
        'createdAt'     => 'transactions.created_at',
        'id'            => 'transactions.id',
        'description'   => 'transactions.description',
        'amount'        => 'amount',
        'statusChangedAt'         => [
            'requests.status_changed_at',
            'transactions.id'
        ],
    ];

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters');
        $serviceData = new ServiceData();
        $account = $serviceData->findById('accounts', 'accounts', $requestFilters['accountId']);
        if(empty($account) || $account->user_id != Authenticate::getLoginUserId())
            throw new \App\Http\Responses\Errors\Params("No access to this account information");

        $filters = ['account_id' => $requestFilters['accountId']];

        if(!empty($requestFilters['dateFrom']))
            $filters['date_from'] = date(DATE_ATOM, strtotime($requestFilters['dateFrom']));

        if(!empty($requestFilters['dateTo']))
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));

        if(empty($requestFilters['status']))
            $filters['status'] = 'executed';

        return $filters;
    }

}
