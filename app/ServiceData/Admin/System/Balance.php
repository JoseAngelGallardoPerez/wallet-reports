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

class Balance extends ServiceData implements ServiceDataInterface
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
            'availableAmount' => 'Available balance',
            'type.currencyCode' => 'Currency',
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM accounts 
        LEFT JOIN account_types ON account_types.id = accounts.type_id ";

        if(!empty($filters['date_to'])){
            $sql .= "WHERE accounts.created_at <= :date_to ";
            $params['date_to'] = $filters['date_to'];
        }

        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT 
        accounts.number, 
        account_types.id,
        account_types.name, 
        account_types.currency_code,
        accounts.created_at, 
        accounts.id,
        accounts.is_active,
        accounts.user_id,
        accounts.balance,
        accounts.available_amount " . $this->getSelect($filters, $params) . " ORDER BY accounts.created_at DESC ";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $userRow = $this->findById('users', 'users', $itemCollection->user_id, 'uid');

            if(empty($filters['date_to'])){
                $availableAmount = $itemCollection->available_amount;
            } else {
                $availableAmount = $this->getAmountTransactions(
                    $itemCollection->id,
                    'executed',
                    $filters['date_to']) + $this->getAmountTransactions(
                        $itemCollection->id,
                        'pending',
                        $filters['date_to']
                    );
            }

            $dataCollection[] = [
                'id' => $itemCollection->id,
                'number' => $itemCollection->number,
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'status' => $itemCollection->is_active == 1 ? true : false,
                'balance' => $this->amountFormat($itemCollection->balance),
                'availableAmount' => $this->amountFormat($availableAmount),
                'type' => [
                    'id' => $itemCollection->id,
                    'name' => $itemCollection->name,
                    'currencyCode' => $itemCollection->currency_code,
                ],
                'user' => [
                    'uid' => empty($userRow) ? '' : $userRow->uid,
                    'firstName' => empty($userRow) ? '' : $userRow->first_name,
                    'lastName' => empty($userRow) ? '' : $userRow->last_name,
                    'username' => empty($userRow) ? '' : $userRow->username,
                    'email' => empty($userRow) ? '' : $userRow->email,
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
