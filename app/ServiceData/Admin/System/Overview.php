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

class Overview extends ServiceData implements ServiceDataInterface
{
    public function getCollection($filters, $options = []): array
    {
        $sql = "SELECT currency_code FROM account_types GROUP BY currency_code";
        $collectionCurrencyCode = $this->select('accounts', $sql);

        $data = [];
        $collectionAccountTypes = $this->select('accounts', "SELECT * FROM account_types");
        foreach ($collectionAccountTypes as $accountType){

            $sqlTransactions = "SELECT SUM(transactions.amount) as total FROM transactions
                    LEFT JOIN accounts ON accounts.id = transactions.account_id
                    WHERE accounts.type_id = :type_id 
                    AND transactions.created_at <= :created_at
                    AND transactions.status = 'executed'";

            $sqlAccounts = "SELECT count(transactions.amount) as total FROM transactions
                    LEFT JOIN accounts ON accounts.id = transactions.account_id
                    WHERE accounts.type_id = :type_id
                    AND accounts.created_at <= :created_at
                    AND transactions.status = 'executed'";

            $params = [
                'type_id' => $accountType->id,
                'created_at' => $filters['date_to']
            ];

            $data['deposits'][] = [
                'name' => $accountType->name,
                'count' => $this->select('accounts', $sqlAccounts, $params)[0]->total,
                'balance' => $this->amountFormat($this->select('accounts', $sqlTransactions, $params)[0]->total),
                'currencyCode' => $accountType->currency_code
            ];
        }

        foreach ($collectionCurrencyCode as $currencyCode) {
            $code = $currencyCode->currency_code;
            $sqlTransactions = "SELECT SUM(transactions.amount) as total, COUNT(transactions.amount) as count_all FROM transactions
                    LEFT JOIN revenue_accounts ON revenue_accounts.id = transactions.revenue_account_id
                    WHERE revenue_accounts.currency_code = :currency_code 
                    AND transactions.created_at <= :created_at
                    AND transactions.status = 'executed'";

            $transactions = $this->select('accounts', $sqlTransactions, [
                'created_at' => $filters['date_to'],
                'currency_code' => $code
            ])[0];

            $data['revenues'][] = [
                'currencyCode' => $code,
                'sum' => $this->amountFormat($transactions->total ? $transactions->total : 0),
                'count' => $transactions->count_all,
            ];

            $code = $currencyCode->currency_code;
            $sqlRevenueAccounts = "SELECT SUM(revenue_accounts.balance) as total FROM revenue_accounts
                    WHERE revenue_accounts.currency_code = :currency_code ";

            $data['revenuesAccounts'][] = [
                'currencyCode' => $code,
                'balance' => $this->amountFormat($this->select('accounts', $sqlRevenueAccounts, ['currency_code' => $code])[0]->total)
            ];

            $sqlRevenueAccounts = "SELECT SUM(accounts.balance) as total FROM accounts
                    LEFT JOIN account_types ON account_types.id = accounts.type_id
                    WHERE account_types.currency_code = :currency_code ";

            $totalBalance = $this->select('accounts', $sqlRevenueAccounts, ['currency_code' => $code])[0]->total;
            $data['totalBalance'][] = [
                'currencyCode' => $code,
                'balance' => $this->amountFormat($totalBalance)
            ];

            $sqlRevenueAccounts = "SELECT count(transactions.amount) as total, COUNT(transactions.amount) as count_all FROM transactions
                    LEFT JOIN accounts ON accounts.id = transactions.account_id
                    LEFT JOIN account_types ON account_types.id = accounts.type_id
                    WHERE account_types.currency_code = :currency_code
                    AND transactions.created_at <= :created_at
                    AND transactions.status = 'pending'";

            $transaction = $this->select('accounts', $sqlRevenueAccounts, [
                'currency_code' => $code,
                'created_at' => $filters['date_to']
            ])[0];

            $data['pendingTransactions'][] = [
                'currencyCode' => $code,
                'amount' => $this->amountFormat($transaction->total),
                'count' => $transaction->count_all
            ];

            $data['futureBalance'][] = [
                'currencyCode' => $code,
                'balance' => $this->amountFormat($totalBalance + $transaction->total)
            ];
        }
        return $data;
    }

    public function getCount($filters): int
    {
        return 0;
    }

    public function getAdditionalEntities($filters)
    {
        $sql = "SELECT users.status, count(*) as total 
        FROM users 
        WHERE users.status IN ('active', 'pending') 
        AND users.created_at <= :created_at
        GROUP BY users.status";

        $total = $this->select('users', $sql, ['created_at' => $filters['date_to']]);
        $data = [];

        foreach ($total as $item){
            $data[$item->status] = $item->total;
        }
        return $data;
    }

    public function _getCollection($filters)
    {
        $collection = $this->getCollection($filters);

        $data = [];

        foreach ($collection['deposits'] as $index=>$deposit){
            $item =['name' => $deposit['name']];

            foreach ($collection['revenues'] as $revenues){
                if($revenues['currencyCode'] == $deposit['currencyCode']){
                    $item[$revenues['currencyCode']] = $deposit['count'] . '|' . $deposit['balance'];
                } else {
                    $item[$revenues['currencyCode']] = '0|0';
                }
            }
            $data[] = $item;
        }

        $template['name'] = 'Name';
        $item = ['name' => 'All generated revenues'];
        foreach ($collection['revenues'] as $index=>$revenues){
            $template[$revenues['currencyCode']] = $revenues['currencyCode'];

            $item[$revenues['currencyCode']] = $revenues['sum'] . '|' . $revenues['count'];
        }
        $data[] = $item;

        $item = ['name' => 'Revenue account balance (not included in currency totals)'];
        foreach ($collection['revenuesAccounts'] as $revenues){
            $item[$revenues['currencyCode']] = $revenues['balance'];
        }
        $data[] = $item;

        $item = ['name' => 'Total balance'];
        foreach ($collection['totalBalance'] as $_item){
            $item[$_item['currencyCode']] = $_item['balance'];
        }
        $data[] = $item;

        $item = ['name' => 'Total pending transactions'];
        foreach ($collection['pendingTransactions'] as $_item){
            $item[$_item['currencyCode']] = $_item['count'];
        }
        $data[] = $item;

        $item = ['name' => 'Future balance'];
        foreach ($collection['futureBalance'] as $_item){
            $item[$_item['currencyCode']] = $_item['balance'];
        }
        $data[] = $item;

        $this->csvTemplate = ['data' => $template];
        return $data;
    }
}
