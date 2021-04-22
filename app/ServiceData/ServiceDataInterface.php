<?php

namespace App\ServiceData;

interface ServiceDataInterface
{
    public function getCount($filters);
    public function getCollection($filters, $options);
    public function getAdditionalEntities($filters);
}
