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

class OutgoingTransfer extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'account.user.firstName' => 'First name',
            'account.user.lastName' => 'Last name',
            'id' => 'Id',
            'account.type.name' => 'Account type',
            'account.type.currencyCode' => 'Currency',
            'account.number' => 'Account number',
            'description' => 'Transaction description',
            'amount' => 'Debit/Credit',
            'statusChangedAt' => 'Date'
        ],
        'summary' => [
            'startDate' => 'Start date',
            'endDate' => 'End date',
            'currencyCode' => 'Currency',
            'totalDebit' => 'Total debit',
            'totalCredit' => 'Total credit'
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM transactions
        LEFT JOIN accounts ON accounts.id = transactions.account_id
        LEFT JOIN account_types ON account_types.id = accounts.type_id
        LEFT JOIN requests ON transactions.request_id = requests.id
        WHERE requests.subject = 'OWT'
        AND transactions.account_id is not null
        AND transactions.status = 'executed'
        AND transactions.is_visible = 1 ";

        $params = [];

        if(!empty($filters['currency_code'])){
            $sql .= "AND account_types.currency_code = :currency_code ";
            $params['currency_code'] = $filters['currency_code'];
        }

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
        account_types.id as type_id,
        account_types.name,
        account_types.currency_code,
        accounts.number,
        accounts.user_id,
        accounts.id as account_id,
        requests.status_changed_at,
        transactions.id,
        transactions.created_at,
        transactions.description,
        transactions.show_amount,
        transactions.amount " . $this->getSelect($filters, $params)
        . "ORDER BY requests.status_changed_at DESC";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $userRow = $this->findById('users', 'users', $itemCollection->user_id, 'uid');
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'description' => $itemCollection->description,
                'amount' => $this->amountFormat($itemCollection->show_amount ? $itemCollection->show_amount : $itemCollection->amount),
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'statusChangedAt' => $this->dateFormat($itemCollection->status_changed_at),
                'account' => [
                    'id' => $itemCollection->account_id,
                    'number' => $itemCollection->number,
                    'type' => [
                        'id' => $itemCollection->type_id,
                        'name' => $itemCollection->name,
                        'currencyCode' => $itemCollection->currency_code,
                    ],
                    'user' => [
                        'uid' => empty($userRow) ? '' : $userRow->uid,
                        'firstName' => empty($userRow) ? '' : $userRow->first_name,
                        'lastName' => empty($userRow) ? '' : $userRow->last_name,
                        'username' => empty($userRow) ? '' : $userRow->username,
                        'email' => empty($userRow) ? '' : $userRow->email
                    ]
                ],

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
        $params = [];
        $sql = "SELECT SUM(transactions.amount) as amount " . $this->getSelect($filters, $params) . "AND transactions.amount < 0 ";
        $totalDebit = $this->select('accounts', $sql, $params)[0]->amount;

        $sql = "SELECT SUM(transactions.amount) as amount " . $this->getSelect($filters, $params) . "AND transactions.amount > 0 ";
        $totalCredit = $this->select('accounts', $sql, $params)[0]->amount;

        return [
            'summary' => [
                'startDate' => date("d/m/Y", $filters['date_from'] ? strtotime($filters['date_from']) : time()),
                'endDate' => date("d/m/Y", $filters['date_to'] ? strtotime($filters['date_to']) : time()),
                'currencyCode' => empty($filters['currency_code']) ? '' : $filters['currency_code'],
                'totalDebit' => $this->amountFormat($totalDebit < 0 ? -1 * $totalDebit : $totalDebit),
                'totalCredit' => $this->amountFormat($totalCredit < 0 ? -1 * $totalCredit : $totalCredit)
            ]
        ];
    }
}
