<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 11.10.2018
 * Time: 12:12
 */

namespace App\ServiceData\Admin\User;

use App\ServiceData\ServiceData;
use App\ServiceData\ServiceDataInterface;

class Transaction extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'id' => 'Id',
            'account.number' => 'Account number',
            'description' => 'Description',
            'amount' => 'Debit/Credit',
            'account.type.currencyCode' => 'Currency',
            'status' => 'Status',
            'statusChangedAt' => 'Date'
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $params = [];

        $sql = "FROM transactions
        LEFT JOIN accounts ON accounts.id = transactions.account_id
        LEFT JOIN account_types ON account_types.id = accounts.type_id
        LEFT JOIN requests ON requests.id = transactions.request_id
        WHERE transactions.id IS NOT NULL
        AND transactions.is_visible = 1 ";

        if (!empty($filters['status'])) {
            $sql .= "AND transactions.status = :status ";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= "AND accounts.user_id = :account_user_id ";
            $params['account_user_id'] = $filters['user_id'];
        } else {
            $sql .= "AND accounts.user_id IS NOT NULL ";
        }

        if (!empty($filters['date_from'])) {
            $sql .= "AND requests.status_changed_at >= :date_from ";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= "AND requests.status_changed_at <= :date_to ";
            $params['date_to'] = $filters['date_to'];
        }

        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT
        account_types.id as account_type_id,
        account_types.currency_code,
        account_types.name,
        accounts.id as account_id,
        accounts.number,
        accounts.balance,
        requests.status_changed_at,
        transactions.id,
        transactions.created_at,
        transactions.status,
        transactions.description,
        transactions.request_id,
        transactions.available_balance_snapshot,
        IF(transactions.show_amount, transactions.show_amount, transactions.amount) as amount " . $this->getSelect($filters, $params);

        if (!empty($options['order'])) {
            $sql .= $options['order'];
        } else {
            $sql .= "ORDER BY requests.status_changed_at desc";
        }

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection) {
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'description' => $itemCollection->description,
                'amount' => $this->amountFormat($itemCollection->amount),
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'statusChangedAt' => $this->dateFormat($itemCollection->status_changed_at),
                'requestId' => $itemCollection->request_id,
                'status' => $itemCollection->status,
                'balanceSnapshot' => $this->amountFormat($itemCollection->available_balance_snapshot),
                'account' => [
                    'id' => $itemCollection->account_id,
                    'number' => $itemCollection->number,
                    'balance' => $this->amountFormat($itemCollection->balance),
                    'type' => [
                        'id' => $itemCollection->account_type_id,
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
