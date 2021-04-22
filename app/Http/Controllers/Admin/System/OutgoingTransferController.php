<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\ControllerInterface;

class OutgoingTransferController extends SystemController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\System\OutgoingTransfer';

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters');

        $filters = [];
        if(!empty($requestFilters['currencyCode']))
            $filters['currency_code'] = $requestFilters['currencyCode'];



        if(!empty($requestFilters['dateFrom'])){
            $filters['date_from'] = date(DATE_ATOM, strtotime($requestFilters['dateFrom']));
        } else {
            $filters['date_from'] = date(DATE_ATOM, 0);
        }

        if(!empty($requestFilters['dateTo'])){
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));
        } else {
            $filters['date_to'] = date(DATE_ATOM);
        }

        return $filters;
    }
}
