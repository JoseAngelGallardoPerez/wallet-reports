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

class Card extends ServiceData implements ServiceDataInterface
{
    protected $csvTemplate = [
        'data' => [
            'number' => 'Card number',
            'type.name' => 'Card type',
            'status' => "Status",
            'user.firstName' => 'First name',
            'user.lastName' => 'Last name',
            'createdAt' => 'Creation date',
        ]
    ];

    public function getSelect($filters, &$params)
    {
        $sql = "FROM cards 
        LEFT JOIN card_types ON card_types.id = cards.card_type_id ";
        return $sql;
    }

    public function getCollection($filters, $options = []): array
    {
        $params = [];

        $sql = "SELECT 
        cards.id,
        cards.number,
        card_types.id as type_id, 
        card_types.name, 
        card_types.currency_code, 
        cards.user_id, 
        cards.created_at, 
        cards.status " . $this->getSelect($filters, $params) . " ORDER BY cards.created_at DESC ";

        $this->setLimitOffset($sql, $options, $params);

        $collection = $this->select('accounts', $sql, $params);

        $dataCollection = [];
        foreach ($collection as $itemCollection){
            $userRow = $this->findById('users', 'users', $itemCollection->user_id, 'uid');
            $dataCollection[] = [
                'id' => $itemCollection->id,
                'number' => $itemCollection->number,
                'status' => $itemCollection->status,
                'createdAt' => $this->dateFormat($itemCollection->created_at),
                'type' => [
                    'id' => $itemCollection->type_id,
                    'name' => $itemCollection->name,
                    'currencyCode' => $itemCollection->currency_code
                ],
                'user' => [
                    'uid' => empty($userRow) ? '' : $userRow->uid,
                    'firstName' => empty($userRow) ? '' : $userRow->first_name,
                    'lastName' => empty($userRow) ? '' : $userRow->last_name,
                    'username' => empty($userRow) ? '' : $userRow->username,
                    'email' => empty($userRow) ? '' : $userRow->email
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
