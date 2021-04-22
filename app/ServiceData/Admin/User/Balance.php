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

class Balance extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
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
        ],
        'user' => [
            'firstName' => 'First name',
            'lastName' => 'Last name',
        ]
    ];
    public function getSelect($filters, &$params)
    {
        $params['user_id'] = $filters['user_id'];

        $sql = "FROM accounts 
        LEFT JOIN account_types ON account_types.id = accounts.type_id
        WHERE accounts.user_id = :user_id ";
        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT 
        account_types.id as type_id,
        account_types.currency_code,
        account_types.name, 
        accounts.number, 
        accounts.id, 
        accounts.created_at, 
        accounts.is_active,
        accounts.balance,
        accounts.available_amount " . $this->getSelect($filters, $params) . " ORDER BY accounts.created_at DESC ";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'number' => $itemCollection->number,
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'status' => $itemCollection->is_active == 1 ? true : false,
                'balance' => $this->amountFormat($itemCollection->balance),
                'availableAmount' => $this->amountFormat($itemCollection->available_amount),
                'type' => [
                    'id' => $itemCollection->type_id,
                    'name' => $itemCollection->name,
                    'currencyCode' => $itemCollection->currency_code,
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
        $userRow = $this->findById('users', 'users', $filters['user_id'], 'uid');

        return [
            'user' => [
                'uid' => $userRow->uid,
                'firstName' => $userRow->first_name,
                'lastName' => $userRow->last_name,
                'username' => $userRow->username,
                'email' => $userRow->email,
            ]
        ];
    }
}
