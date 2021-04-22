<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\ControllerInterface;

class AccessController extends SystemController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\Admin\System\Access';
}
