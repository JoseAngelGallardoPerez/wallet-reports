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

class Revenue extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'user.firstName' => 'First name',
            'user.lastName' => 'Last name',
            'id' => 'Id',
            'account.type.name' => 'Account type',
            'account.number' => 'Account number',
            'description' => 'Transaction description',
            'amount' => 'Debit/Credit',
            'statusChangedAt' => 'Date',
            'account.type.currencyCode' => 'Currency'
        ],
        'summary' => [
            'startDate' => [
                'type' => 'date_time',
                'label' => 'Start date'
            ],
            'endDate' => [
                'type' => 'date_time',
                'label' => 'End date'
            ],
            'currencyCode' => 'Currency',
            'totalDebit' => 'Total debit',
            'totalCredit' => 'Total credit'
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM transactions
                left join requests on requests.id = transactions.request_id
                left join transactions as fee_transactions on fee_transactions.request_id = transactions.request_id
                and fee_transactions.type = 'fee' and transactions.amount = (-1 * fee_transactions.amount)
                left join transactions as user_transactions on user_transactions.request_id = transactions.request_id
                and transactions.amount = (-1 * user_transactions.amount)
                where transactions.type= 'revenue'
                AND transactions.status = 'executed'
                AND requests.base_currency_code = :currency_code ";

        $params['currency_code'] = $filters['currency_code'];

        if(!empty($filters['date_from'])){
            $sql .= "AND requests.status_changed_at >= :date_from ";
            $params['date_from'] = $filters['date_from'];
        }

        if(!empty($filters['date_to'])){
            $sql .= "AND requests.status_changed_at <= :date_to ";
            $params['date_to'] = $filters['date_to'];
        }

        if(!empty($filters['type'])){
            if($filters['type'] == 'manual'){
                $sql .= "and (requests.user_id <> '@system' and fee_transactions.id is null)";
            } else if($filters['type'] == 'system'){
                $sql .= "and (requests.user_id = '@system' or fee_transactions.id is not null)";
            }
        }

        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];
        $sql = "SELECT
        transactions.id, 
        transactions.created_at,
        transactions.request_id, 
        requests.subject,
        requests.user_id,
        requests.status_changed_at,
        transactions.description,
        user_transactions.account_id as account_id,
        transactions.amount " . $this->getSelect($filters, $params) . " ORDER BY requests.status_changed_at DESC";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);
        $subjects = $this->findAllSubjects();

        $dataCollection = [];
        foreach ($collection as $itemCollection){

            if($itemCollection->account_id){
                $account = $this->select('accounts', "SELECT
                        accounts.id,
                        accounts.number,
                        accounts.user_id,
                        account_types.id as account_types_id,
                        account_types.name as account_types_name,
                        account_types.currency_code as account_types_currency_code
                        FROM accounts
                        LEFT JOIN account_types ON account_types.id = accounts.type_id
                        WHERE accounts.id = :account_id", [
                    'account_id' => $itemCollection->account_id
                ])[0];

                $userID = $account->user_id;

                $account = [
                    'id' => $account->id,
                    'number' => $account->number,
                    'type' => [
                        'id' => $account->account_types_id,
                        'name' => $account->account_types_name,
                        'currencyCode' => $account->account_types_currency_code
                    ]
                ];

            } else {
                $userID = $itemCollection->user_id;

                $account = [
                    'id' => "-",
                    'number' => "-",
                    'type' => [
                        'id' => "-",
                        'name' => "-",
                        'currencyCode' => "-"
                    ]
                ];
            }

            $userRow = $this->findById('users', 'users', $userID, 'uid');

            $user = [
                'uid' => empty($userRow) ? '-' : $userRow->uid,
                'firstName' => empty($userRow) ? '-' : $userRow->first_name,
                'lastName' => empty($userRow) ? '-' : $userRow->last_name,
                'username' => empty($userRow) ? '-' : $userRow->username,
                'email' => empty($userRow) ? '' : $userRow->email
            ];

            $account['user'] = $user;

            $dataCollection[] = [
                'id' => $itemCollection->id,
                'description' => $itemCollection->description,
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'statusChangedAt' => $this->dateFormat($itemCollection->status_changed_at),
                'subject' => $subjects[$itemCollection->subject],
                'amount' => $this->amountFormat($itemCollection->amount),
                'user' => $user,
                'account' => $account
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

        $params = [];
        if(empty($filters['date_from'])){
            $min = $this->select('accounts', "SELECT transactions.created_at " . $this->getSelect($filters, $params) . " ORDER BY transactions.created_at ASC LIMIT 1", $params);
            if(!empty($min))
                $filters['date_from'] = $min[0]->created_at;
        }

        if(empty($filters['date_to'])){
            $max = $this->select('accounts', "SELECT transactions.created_at " . $this->getSelect($filters, $params) . " ORDER BY transactions.created_at DESC LIMIT 1", $params);
            if(!empty($max))
                $filters['date_to'] = $max[0]->created_at;
        }

        return [
            'summary' => [
                'startDate' => !empty($filters['date_from']) ? $this->dateFormat($filters['date_from']) : '-',
                'endDate' => !empty($filters['date_to']) ?  $this->dateFormat($filters['date_to']) : '-',
                'currencyCode' => $filters['currency_code'],
                'totalDebit' => $this->amountFormat($totalDebit < 0 ? -1 * $totalDebit : $totalDebit),
                'totalCredit' => $this->amountFormat($totalCredit < 0 ? -1 * $totalCredit : $totalCredit)
            ]
        ];
    }
}
