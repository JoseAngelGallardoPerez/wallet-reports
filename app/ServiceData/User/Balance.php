<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 11.10.2018
 * Time: 12:12
 */
namespace App\ServiceData\User;
use App\ServiceData\ServiceData;
use App\ServiceData\ServiceDataInterface;

class Balance extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [

        ],
        '_items' => [
            'collection' => [
                'name' => 'Account type',
                'numberOfAccounts' => 'Number of accounts',
                'currencyCode' => 'Currency',
                'totalBalances' => 'Total balances'
            ],
            'objects' => [
                'totalBalances' => 'Total balances',
                'pendingTransactions' => 'Pending transactions',
                'futureBalance' => 'Future balance',
            ]

        ]
    ];

    public function getSelect($filters, &$params)
    {
        $params['user_id'] = $filters['user_id'];

        $sql = "FROM account_types
        LEFT JOIN accounts ON account_types.id = accounts.type_id
        WHERE accounts.user_id = :user_id ";
        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT 
        account_types.id, 
        account_types.currency_code, 
        account_types.name, 
        count(accounts.id) as number_of_accounts, 
        SUM(accounts.balance) as total_balances " . $this->getSelect($filters, $params) . "group by account_types.id";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'name' => $itemCollection->name,
                'currencyCode' => $itemCollection->currency_code,
                'numberOfAccounts' => $itemCollection->number_of_accounts,
                'totalBalances' => $this->amountFormat($itemCollection->total_balances),
            ];
        }
        return $dataCollection;
    }

    public function getCount($filters): int
    {
        $params = [];
        $sql = "SELECT count(*) as totalCount " . $this->getSelect($filters, $params) . 'group by account_types.id';
        $collection = $this->select('accounts', $sql, $params);

        return count($collection);
    }

    public function getAdditionalEntities($filters)
    {
        $sql = "SELECT SUM(accounts.balance) as total_balances, account_types.currency_code FROM account_types
        LEFT JOIN accounts ON account_types.id = accounts.type_id
        WHERE accounts.user_id = :user_id
        GROUP BY account_types.id, account_types.currency_code";

        $types = $this->select('accounts', $sql, [
            'user_id' => $filters['user_id']
        ]);
        $data = [];

        foreach ($types as $type){

            $sql = "SELECT SUM(transactions.amount) as sum_amount, COUNT(transactions.id) as transactions_count
            FROM transactions
            LEFT JOIN accounts ON accounts.id = transactions.account_id
            LEFT JOIN account_types ON account_types.id = accounts.type_id
            WHERE transactions.status = 'pending' AND account_types.currency_code = :currency_code AND accounts.user_id = :user_id
            GROUP BY accounts.type_id";

            $item = $this->select('accounts', $sql, [
                'currency_code' => $type->currency_code,
                'user_id' => $filters['user_id']
            ]);

            if (!isset($data[$type->currency_code])) {
                $data[$type->currency_code] = [
                    'totalBalances' => 0,
                    'pendingTransactions' => 0,
                    'futureBalance' => 0,
                ];
            }

            $curItem = $data[$type->currency_code];

            $curItem = [
                'currencyCode' => $type->currency_code,
                'totalBalances' => $type->total_balances + $curItem['totalBalances'],
                'pendingTransactions' => (empty($item) ? 0 : $item[0]->transactions_count) + $curItem['pendingTransactions'],
                'futureBalance' => (empty($item) ? $type->total_balances : $type->total_balances + $item[0]->sum_amount + $curItem['futureBalance']),
            ];

            $data[$type->currency_code] = $curItem;
        }

        foreach ($data as &$item) {
            $item['totalBalances'] = $this->amountFormat($item['totalBalances']);
            $item['futureBalance'] = $this->amountFormat($item['futureBalance']);
        }

        return $data;
    }

    public function getItems($filters)
    {
        return [
            'collection' => $this->getCollection($filters),
            'objects' => $this->getAdditionalEntities($filters)
        ];
    }

    public function _getAdditionalEntities($filters)
    {
        return $this->getCollection($filters);
    }
}
