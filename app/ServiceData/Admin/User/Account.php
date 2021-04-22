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

class Account extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'account' => [
            'createdAt' => 'Creation date',
            'number' => 'Number',
            'type.name' => 'Type',
            'type.currencyCode' => 'Currency',
            'availableAmount' => 'Available balance',
            'balance' => 'Current balance',
        ],
        'user' => [
            'createdAt' => 'Creation date',
            'companyName' => 'Company Name',
            'firstName' => 'First name',
            'lastName' => 'Last name',
        ],
        'data' => [
            'id' => 'ID',
            'description' => 'Description',
            'amount' => 'Debit/Credit',
            'status' => 'Status',
            'statusChangedAt' => 'Date',
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $params['account_id'] = $filters['account_id'];

        $sql = "FROM transactions
        LEFT JOIN requests ON requests.id = transactions.request_id
        WHERE transactions.account_id = :account_id
        AND transactions.is_visible = 1 ";

        if(!empty($filters['status'])){
            $sql .= "AND transactions.status = :status ";
            $params['status'] = $filters['status'];
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

    public function getCollection($filters, $options = [])
    {
        $params = [];

        $sql = "SELECT
        transactions.id,
        transactions.created_at,
        transactions.status,
        transactions.description,
        transactions.available_balance_snapshot,
        requests.status_changed_at,
        transactions.request_id,
        IF(transactions.show_amount, transactions.show_amount, transactions.amount) as amount 
        " . $this->getSelect($filters, $params);

        if(!empty($options['order'])){
            $sql .= $options['order'];
        } else {
            $sql .= "ORDER BY requests.status_changed_at desc";
        }

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);
        $dataCollection = [];

        foreach ($collection as $itemCollection){
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'description' => $itemCollection->description,
                'amount' => $this->amountFormat($itemCollection->amount),
                'requestId' => $itemCollection->request_id,
                'balanceSnapshot' => $this->amountFormat($itemCollection->available_balance_snapshot),
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'statusChangedAt' => $this->dateFormat($itemCollection->status_changed_at),
                'status' => $itemCollection->status,
            ];
        }
        return $dataCollection;
    }

    public function getCount($filters): int
    {
        $params = [];
        $sql = "SELECT count(transactions.id) as totalCount " . $this->getSelect($filters, $params);
        $count = $this->select('accounts', $sql, $params);

        return $count[0]->totalCount;
    }

    public function getAdditionalEntities($filters)
    {
        $sql = "SELECT
        accounts.id,
        accounts.created_at,
        accounts.user_id,
        accounts.number,
        account_types.id as type_id,
        account_types.name,
        account_types.currency_code,
        accounts.balance,
        accounts.available_amount
        FROM accounts
        LEFT JOIN account_types ON account_types.id = accounts.type_id
        WHERE accounts.id = :id";

        $accountRow = $this->select('accounts', $sql, ['id' => $filters['account_id']])[0];

        $accountData = [
            'id' => $accountRow->id,
            'number' => $accountRow->number,
            'balance' => $this->amountFormat($accountRow->balance),
            'availableAmount' => $this->amountFormat($accountRow->available_amount),
            'createdAt' => $this->dateFormat($accountRow->created_at),
            'type' => [
                'id' => $accountRow->type_id,
                'name' => $accountRow->name,
                'currencyCode' => $accountRow->currency_code,
            ]
        ];

        $userRow = $this->findById('users', 'users', $accountRow->user_id, 'uid');

        $userData = [
            'uid' => $userRow->uid,
            'username' => $userRow->username,
            'email' => $userRow->email,
            'firstName' => $userRow->first_name,
            'lastName' => $userRow->last_name,
            'companyName' => '',
            'createdAt' => $userRow->created_at,
        ];

        $userData['companyName'] = $userRow->is_corporate ? $userRow->company_name : '';

        return [
            'user' => $userData,
            'account' => $accountData
        ];
    }
}
