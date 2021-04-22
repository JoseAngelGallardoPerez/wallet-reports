<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get("/reports/health-check", function(){
   return \App\Http\Responses\Json::ok();
});

$router->group(['prefix' => 'reports/private/v1'], function () use ($router) {
    $router->group(['middleware' => 'App\Http\Middleware\UserAuthenticate'], function($router) {

        /* Users */
        $router->get('account',                                 ['uses' => 'User\AccountController@sheet']);
        $router->get('balance',                                 ['uses' => 'User\BalanceController@sheet']);
        $router->get('transaction',                             ['uses' => 'User\TransactionController@sheet']);

        $router->get('account/export',                          ['uses' => 'User\AccountController@export']);
        $router->get('balance/export',                          ['uses' => 'User\BalanceController@export']);
        $router->get('transaction/export',                      ['uses' => 'User\TransactionController@export']);
    });

    $router->group(['middleware' => 'App\Http\Middleware\AdminUserAuthenticate'], function($router) {
        /* Admin Users */
        $router->get('admin/user/account',                      ['uses' => 'Admin\User\AccountController@sheet']);
        $router->get('admin/user/balance',                      ['uses' => 'Admin\User\BalanceController@sheet']);
        $router->get('admin/user/transaction',                  ['uses' => 'Admin\User\TransactionController@sheet']);

        $router->get('admin/user/account/export',               ['uses' => 'Admin\User\AccountController@export']);
        $router->get('admin/user/balance/export',               ['uses' => 'Admin\User\BalanceController@export']);
        $router->get('admin/user/transaction/export',           ['uses' => 'Admin\User\TransactionController@export']);
    });

    $router->group(['middleware' => 'App\Http\Middleware\AdminSystemAuthenticate'], function($router) {
        /* Admin Systems */
        $router->get('admin/system/transaction',                ['uses' => 'Admin\System\TransactionController@sheet']);
        $router->get('admin/system/balance',                    ['uses' => 'Admin\System\BalanceController@sheet']);
        $router->get('admin/system/maturity',                   ['uses' => 'Admin\System\MaturityController@sheet']);
        $router->get('admin/system/outgoing-transfer',          ['uses' => 'Admin\System\OutgoingTransferController@sheet']);
        $router->get('admin/system/card',                       ['uses' => 'Admin\System\CardController@sheet']);
        $router->get('admin/system/manual-transaction',         ['uses' => 'Admin\System\ManualTransactionController@sheet']);
        $router->get('admin/system/interests',                  ['uses' => 'Admin\System\InterestController@sheet']);
        $router->get('admin/system/revenue',                    ['uses' => 'Admin\System\RevenueController@sheet']);
        $router->get('admin/system/access',                     ['uses' => 'Admin\System\AccessController@sheet']);
        $router->get('admin/system/overview',                   ['uses' => 'Admin\System\OverviewController@sheet']);

        $router->get('admin/system/transaction/export',         ['uses' => 'Admin\System\TransactionController@export']);
        $router->get('admin/system/balance/export',             ['uses' => 'Admin\System\BalanceController@export']);
        $router->get('admin/system/maturity/export',            ['uses' => 'Admin\System\MaturityController@export']);
        $router->get('admin/system/outgoing-transfer/export',   ['uses' => 'Admin\System\OutgoingTransferController@export']);
        $router->get('admin/system/card/export',                ['uses' => 'Admin\System\CardController@export']);
        $router->get('admin/system/manual-transaction/export',  ['uses' => 'Admin\System\ManualTransactionController@export']);
        $router->get('admin/system/interests/export',           ['uses' => 'Admin\System\InterestController@export']);
        $router->get('admin/system/revenue/export',             ['uses' => 'Admin\System\RevenueController@export']);
        $router->get('admin/system/access/export',              ['uses' => 'Admin\System\AccessController@export']);
        $router->get('admin/system/overview/export',            ['uses' => 'Admin\System\OverviewController@export']);
    });
});


