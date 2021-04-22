<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\ControllerInterface;

class OverviewController extends SystemController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\System\Overview';
    protected $includeLinks = false;

    public function getFilters()
    {
        $requestFilters = $this->getRequest()->get('filters');
        $filters = [];

        if(!empty($requestFilters['dateTo'])){
            $filters['date_to'] = date(DATE_ATOM, strtotime($requestFilters['dateTo']));
        } else {
            $filters['date_to'] = date(DATE_ATOM);
        }

        return $filters;
    }

    protected function includeAdditionalEntities()
    {
        return true;
    }
}
