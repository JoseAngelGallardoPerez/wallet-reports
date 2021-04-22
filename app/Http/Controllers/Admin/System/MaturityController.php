<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\ControllerInterface;

class MaturityController extends SystemController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\System\Maturity';

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters');
        $filters = [];

        if(!empty($requestFilters['dateFrom']))
            $filters['date_from'] = date(DATE_ATOM, strtotime($requestFilters['dateFrom']));

        if(!empty($requestFilters['dateTo']))
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));

        return $filters;
    }

}
