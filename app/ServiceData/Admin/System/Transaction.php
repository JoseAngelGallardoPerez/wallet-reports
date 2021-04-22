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

class Transaction extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'account.user.firstName' => 'First name',
            'account.user.lastName' => 'Last name',
            'id' => 'Id',
            'account.type.name' => 'Account type',
            'account.number' => 'Account number',
            'description' => 'Transaction description',
            'amount' => 'Debit/Credit',
            'account.type.currencyCode' => 'Currency',
            'statusChangedAt' => 'Date'
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM transactions
        LEFT JOIN accounts ON accounts.id = transactions.account_id
        LEFT JOIN account_types ON account_types.id = accounts.type_id
        LEFT JOIN requests ON requests.id = transactions.request_id
        WHERE transactions.account_id IS NOT NULL
        AND transactions.status = 'executed'
        AND transactions.is_visible = 1 ";

        if(!empty($filters['date_from'])){
            $sql .= "AND requests.status_changed_at >= :date_from ";
            $params['date_from'] = $filters['date_from'];
        }

        if(!empty($filters['date_to'])){
            $sql .= "AND requests.status_changed_at <= :date_to ";
            $params['date_to'] = $filters['date_to'];
        }
        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT
        transactions.purpose,
        account_types.id as type_id,
        account_types.currency_code,
        account_types.name,
        accounts.id as account_id,
        accounts.number,
        accounts.user_id,
        requests.status_changed_at,
        transactions.id,
        transactions.created_at,
        transactions.description,
        transactions.show_amount,
        transactions.amount " . $this->getSelect($filters, $params)
        . "ORDER BY requests.status_changed_at desc";

        $this->setLimitOffset($sql, $options, $params);



        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){

            $userRow = $this->findById('users', 'users', $itemCollection->user_id, 'uid');
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'description' => $itemCollection->description,
                'purpose' => $itemCollection->purpose,
                'amount' => $this->amountFormat($itemCollection->show_amount ? $itemCollection->show_amount : $itemCollection->amount),
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'statusChangedAt' => $this->dateFormat($itemCollection->status_changed_at),
                'account' => [
                    'id' => $itemCollection->account_id,
                    'number' => $itemCollection->number,
                    'user' => [
                        'uid' => empty($userRow) ? '' : $userRow->uid,
                        'firstName' => empty($userRow) ? '' : $userRow->first_name,
                        'lastName' => empty($userRow) ? '' : $userRow->last_name,
                        'username' => empty($userRow) ? '' : $userRow->username,
                        'email' => empty($userRow) ? '' : $userRow->email
                    ],
                    'type' => [
                        'id' => $itemCollection->type_id,
                        'name' => $itemCollection->name,
                        'currencyCode' => $itemCollection->currency_code
                    ]
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
