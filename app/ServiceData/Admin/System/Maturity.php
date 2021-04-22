<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 11.10.2018
 * Time: 12:12
 */
namespace App\ServiceData\Admin\System;
use App\ServiceData\ServiceData;
use App\ServiceData\ServiceDataInterface;

class Maturity extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'user.firstName' => 'First name',
            'user.lastName' => 'Last name',
            'number' => 'Account number',
            'type.name' => 'Account type',
            'createdAt' => 'Account creation date',
            'status' => [
                'type' => 'if_boolean',
                'true' => 'Active',
                'false' => 'Blocked',
                'label' => 'Status'
            ],
            'balance' => 'Current balance',
            'maturityDate' => [
                'type' => 'date_time',
                'label' => 'Maturity date'
            ],
            'type.currencyCode' => 'Currency',
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM accounts 
        LEFT JOIN account_types ON account_types.id = accounts.type_id
        WHERE accounts.maturity_date IS NOT NULL";

        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT 
        accounts.id, 
        accounts.number, 
        account_types.name, 
        account_types.currency_code, 
        account_types.id as type_id, 
        accounts.created_at, 
        accounts.is_active,
        accounts.user_id,
        accounts.balance,
        accounts.maturity_date " . $this->getSelect($filters, $params) . " ORDER BY accounts.created_at DESC ";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $userRow = $this->findById('users', 'users', $itemCollection->user_id, 'uid');
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'number' => $itemCollection->number,
                'status' => $itemCollection->is_active == 1 ? true : false,
                'balance' => $this->amountFormat($itemCollection->balance),
                'maturityDate' => $this->dateFormat($itemCollection->maturity_date),
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'user' => [
                    'uid' => empty($userRow) ? '' : $userRow->uid,
                    'firstName' => empty($userRow) ? '' : $userRow->first_name,
                    'lastName' => empty($userRow) ? '' : $userRow->last_name,
                    'username' => empty($userRow) ? '' : $userRow->username
                    'email' => empty($userRow) ? '' : $userRow->email
                ],
                'type' => [
                    'id' => $itemCollection->type_id,
                    'name' => $itemCollection->name,
                    'currencyCode' => $itemCollection->currency_code
                ]
            ];
        }
        return $dataCollection;
    }

    public function getCount($filters): int
    {
        $params = [];
        $sql = "SELECT count(*) as totalCount " . $this->getSelect($filters, $params);
        $count = $this->select('accounts', $sql, $params);

        return $count[0]->totalCount;
    }

    public function getAdditionalEntities($filters)
    {
        return [];
    }
}
