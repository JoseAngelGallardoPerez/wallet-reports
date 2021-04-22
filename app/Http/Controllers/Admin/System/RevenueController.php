<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\ControllerInterface;

class RevenueController extends SystemController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\System\Revenue';
    protected $requiredFilterFields = ['currencyCode'];

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters');

        $filters = [
            'currency_code' => $requestFilters['currencyCode']
        ];

        if(!empty($requestFilters['dateFrom'])){
            $filters['date_from'] = date(DATE_ATOM, strtotime($requestFilters['dateFrom']));
        }

        if(!empty($requestFilters['dateTo'])){
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));
        }

        if(!empty($requestFilters['type']))
            $filters['type'] = in_array($requestFilters['type'], ['manual', 'system', 'all']) ? $requestFilters['type'] : 'all';

        return $filters;
    }
}
