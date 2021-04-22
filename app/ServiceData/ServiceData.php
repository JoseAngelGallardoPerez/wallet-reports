<?php

namespace App\ServiceData;

class ServiceData
{
    /**
     * @param $connectionName
     * @param $select
     * @param $values
     * @return array
     */
    protected $csvTemplate = [];

    /**
     * general settings from SettingsService
     */
    protected $settings = [];

    protected function select($connectionName, $select, $values = [])
    {
        return app('db')->connection($connectionName)->select($select, $values);
    }

    public function findById($connectionName, $tableName, $id, $fieldAiName = 'id')
    {
        $result = $this->select($connectionName, "SELECT * FROM $tableName WHERE $fieldAiName = :id", ['id' => $id]);
        return empty($result) ? [] : $result[0];
    }

    protected function findAll($connectionName, $tableName)
    {
        return $this->select($connectionName, "SELECT * FROM $tableName");
    }

    protected function findAllCurrencies()
    {
        $currenciesRows = $this->findAll('currencies', 'currencies');
        $currencies = [];
        foreach ($currenciesRows as $currency) {
            $currencies[$currency->id] = $currency->name;
        }

        return $currencies;
    }

    protected function findAllSubjects()
    {
        $objectRows = $this->findAll('accounts', 'request_subjects');
        $objects = [];
        foreach ($objectRows as $objeck) {
            $objects[$objeck->subject] = $objeck->description;
        }

        return $objects;
    }

    public function setLimitOffset(&$sql, &$options, &$params)
    {
        if (!empty($options)) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params['limit'] = $options['limit'];
            $params['offset'] = $options['offset'];
        }
    }

    protected function getValueByKey($arrayItem, $keyArray)
    {
        foreach ($keyArray as $key) {
            if (isset($arrayItem[$key])) {
                $arrayItem = $arrayItem[$key];
            } else {
                $arrayItem = "";
            }

        }
        return $arrayItem;
    }

    public function formatCsv($string)
    {
        $string = str_replace('"', '""', $string);
        return '"' . $string . '"';
    }

    public function getCsvData($filters)
    {

        $csvArray = [];
        if (isset($this->csvTemplate['_items'])) {
            $items = $this->getItems($filters);
            $tmp = $this->csvTemplate['_items'];

            if (empty($csvArray)) {
                $csvArray['collection_item'] = [];
            }

            $dTmp = [];
            foreach ($items['collection'] as $entity){
                if (isset($entity['createdAt'])) {
                    $entity['createdAt'] = $this->dateFormatForCsv($entity['createdAt']);
                }
                foreach ($tmp['collection'] as $indexTmp => $valueTmp){
                    $arrayData[$this->formatCsv($valueTmp)] = $this->formatCsv($this->getValueByKey($entity, explode('.', $indexTmp)));
                }
                $csvArray['collection_item'][] = $dTmp;
            }

            foreach ($items['objects'] as $index => $entity) {
                $csvArray['collection_item' . $index][] = [
                    $index => $index,
                    '' => ''
                ];
                foreach ($tmp['objects'] as $indexTmp => $valueTmp) {
                    $csvArray['collection_item' . $index][] = [
                        $index => $valueTmp,
                        '' => $this->formatCsv($this->getValueByKey($entity, explode('.', $indexTmp)))
                    ];
                }

            }

            $csvArray[] = [];
            $csvArray[] = [];

        } else {
            $entities = $this->_getAdditionalEntities($filters);

            if (!empty($entities)) {
                foreach ($entities as $index => $entity) {
                    if (isset($entity['createdAt'])) {
                        $entity['createdAt'] = $this->dateFormatForCsv($entity['createdAt']);
                    }
                    if (isset($this->csvTemplate[$index])) {

                        $tmp = $this->csvTemplate[$index];
                        $arrayEntity = [];
                        foreach ($tmp as $indexTmp => $valueTmp){
                            if(is_array($valueTmp)){
                                switch ($valueTmp['type']){
                                    case 'if_boolean':
                                        $value = $this->getValueByKey($entity, explode('.', $indexTmp));
                                        $value = $value ? $valueTmp['true'] : $valueTmp['false'];
                                        $arrayEntity[$this->formatCsv($valueTmp['label'])] = $this->formatCsv($value);
                                        break;
                                    case 'date_time':
                                        $value =  $this->getValueByKey($entity, explode('.', $indexTmp));
                                        $value = $this->dateFormatForCsv($value);
                                        $arrayEntity[$this->formatCsv($valueTmp['label'])] = $this->formatCsv($value);
                                        break;
                                    default:break;
                                }
                            } else {
                                $arrayEntity[$this->formatCsv($valueTmp)] = $this->formatCsv($this->getValueByKey($entity, explode('.', $indexTmp)));
                            }
                        }

                        $csvArray[$index] = $arrayEntity;
                        $csvArray[] = [];
                        $csvArray[] = [];
                    }
                }
            }
        }

        $collection = $this->_getCollection($filters);
        $csvArray['collection'] = [];

        $tmp = $this->csvTemplate['data'];

        foreach ($collection as $item) {
            if (isset($item['createdAt'])) {
                $item['createdAt'] = $this->dateFormatForCsv($item['createdAt']);
            }
            if (isset($item['statusChangedAt'])) {
                $item['statusChangedAt'] = $this->dateFormatForCsv($item['statusChangedAt']);
            }
            $arrayData = [];
            foreach ($tmp as $indexTmp => $valueTmp) {
                if(is_array($valueTmp)){
                    switch ($valueTmp['type']){
                        case 'if_boolean':
                            $value = $this->getValueByKey($item, explode('.', $indexTmp));
                            $value = $value ? $valueTmp['true'] : $valueTmp['false'];
                            $arrayData[$this->formatCsv($valueTmp['label'])] = $this->formatCsv($value);
                            break;
                        case 'date_time':
                            $value =  $this->getValueByKey($item, explode('.', $indexTmp));
                            $value = $this->dateFormatForCsv($value);
                            $arrayData[$this->formatCsv($valueTmp['label'])] = $this->formatCsv($value);
                            break;
                        default:break;
                    }
                } else {
                    $arrayData[$this->formatCsv($valueTmp)] = $this->formatCsv($this->getValueByKey($item, explode('.', $indexTmp)));
                }

            }
            $csvArray['collection'][] = $arrayData;
        }

        return $csvArray;
    }

    protected function amountFormat($amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    protected function dateFormat($date)
    {
        return date(DATE_ATOM, strtotime($date));
    }

    protected function dateFormatForCsv($date)
    {
        try {
            $settings = $this->getSettings();
            $date = \Carbon\Carbon::parse($date)->timezone($settings['default_timezone']);

            return $date->format($settings['default_date_format'] . ' ' . $settings['default_time_format']);
        } catch (\Throwable $e) {
            return date(DATE_ATOM, strtotime($date));
        }
    }

    protected function getSettings()
    {
        if (!$this->settings) {
            $result = app('db')->connection('settings')->select(
                "SELECT * FROM configs WHERE path LIKE :path",
                ['path' => 'regional/general%']
            );

            foreach ($result as $item) {
                $path = explode('/', $item->path);
                $key = $path[2];
                $this->settings[$key] = $item->value;
            }

            if (isset($this->settings['default_date_format'])) {
                $search = ['YYYY', 'DD', 'MM'];
                $replace = ['Y', 'd', 'm'];
                $this->settings['default_date_format'] = str_replace(
                    $search,
                    $replace,
                    $this->settings['default_date_format']
                );
            }

            if (isset($this->settings['default_time_format'])) {
                $search = ['HH', 'hh', 'a', 'mm', 'ss'];
                $replace = ['H', 'h', 'A', 'i', 's'];
                $this->settings['default_time_format'] = str_replace(
                    $search,
                    $replace,
                    $this->settings['default_time_format']
                );
            }

        }

        return $this->settings;
    }

    public function _getCollection($filters)
    {
        return $this->getCollection($filters);
    }

    public function _getAdditionalEntities($filters)
    {
        return $this->getAdditionalEntities($filters);
    }

    public function getItems($filters)
    {
        return [];
    }

    protected function getAmountTransactions($accountId, $status, $dateTo)
    {
        $sql = "SELECT SUM(transactions.amount) as total
        FROM transactions
        WHERE transactions.status = :status 
        AND transactions.account_id = :account_id 
        AND transactions.created_at <= :created_at";

        $params = [
            'account_id' => $accountId,
            'status' => $status,
            'created_at' => $dateTo
        ];

        $total = $this->select('accounts', $sql, $params)[0]->total;
        return $total ? $total : 0;
    }

}
