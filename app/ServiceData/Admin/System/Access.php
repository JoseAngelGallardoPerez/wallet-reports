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

class Access extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'createdAt' => 'Date',
            'ip' => 'IP',
            'user.firstName' => 'First name',
            'user.lastName' => 'Last name',
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM users_accesslog 
        LEFT JOIN users ON users.uid = users_accesslog.uid ";
        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT 
        users.first_name,
        users.last_name,
        users.username,
        users.email,
        users.uid,
        users_accesslog.alid,
        users_accesslog.created_at,
        INET_NTOA(users_accesslog.ip) as _ip " . $this->getSelect($filters, $params)
        . "ORDER BY users_accesslog.created_at DESC ";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('users', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $dataCollection[] = [
                'id' => $itemCollection->alid,
                'ip' => $itemCollection->_ip,
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'user' => [
                    'uid' => $itemCollection->uid,
                    'firstName' => $itemCollection->first_name,
                    'lastName' => $itemCollection->last_name,
                    'username' => $itemCollection->username,
                    'email' => $itemCollection->email,
                ]
            ];
        }
        return $dataCollection;
    }

    public function getCount($filters): int
    {
        $params = [];
        $sql = "SELECT count(*) as totalCount " . $this->getSelect($filters, $params);
        $count = $this->select('users', $sql, $params);

        return $count[0]->totalCount;
    }

    public function getAdditionalEntities($filters)
    {
        return [];
    }
}
