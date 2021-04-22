<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use App\Http\Responses\Csv as ResponsesCsv;
use App\Http\Responses\Json as ResponsesJson;

class Controller extends BaseController implements ControllerInterface
{
    protected $nameDataService = 'App\ServiceData\ServiceData';
    protected $requiredFilterFields = [];
    protected $orders = [];
    protected $request;
    protected $includeLinks = true;

    function __construct(Request $request)
    {
        if($request->isJson())
            $request->request->add($request->query());

        $this->request = $request;
    }

    protected function getRequest()
    {
        return $this->request->request;
    }

    protected function _getRequest()
    {
        return $this->request;
    }

    protected function getFilters()
    {
        return [];
    }

    protected function filters()
    {
        $requestFilters = $this->getRequest()->get('filters');
        foreach ($this->requiredFilterFields as $field){
            if(empty($requestFilters[$field]))
                throw new \App\Http\Responses\Errors\Params("For a correct answer specify the required fields: " . implode(', ' , $this->requiredFilterFields));
        }

        return $this->getFilters();
    }

    public function getOrder()
    {
        $sort = $this->getRequest()->get('sort');
        if($sort){
            $sortField = str_replace('-', '', $sort);
            if(isset($this->orders[$sortField])){
                if (is_array($this->orders[$sortField])) {
                    $last = end($this->orders[$sortField]);
                    $stm = ' ORDER BY ';
                    foreach ($this->orders[$sortField] as $order) {
                        $stm .= $order . (substr_count($sort, '-') ? ' DESC' : ' ASC') . ($order === $last ? '' : ', ');
                    }
                    return $stm;
                }
                return ' ORDER BY ' . $this->orders[$sortField] . (substr_count($sort, '-') ? ' DESC' : ' ASC');
            }
        }
        return '';
    }

    public function sheet()
    {
        return $this->sheetResponse($this->filters());
    }

    public function export()
    {
        return $this->csvResponse($this->filters());
    }

    protected function sheetResponse(array $filters = [], array $data = [])
    {
        $service = new $this->nameDataService();

        $countAll = $service->getCount($filters);

        $params = $this->getRequest()->getIterator();

        if(empty($params['page']['size']) || $params['page']['size'] > 100 || $params['page']['size'] < 1)
            $params['page']['size'] = 10;

        if(empty($params['page']['number']) || $params['page']['number'] < 1)
            $params['page']['number'] = 1;

        $pageNumber = $params['page']['number'];
        $pageSize = $params['page']['size'];
        $countPages = ceil($countAll / $pageSize);

        if($pageNumber > $countPages){
            $pageNumber = $params['page']['number'] = $countPages;
        }

        $links = [
            'first' => 1,
            'last' => $countPages,
            'self' => $pageNumber,
            'next' => (($pageNumber + 1) > $countPages) ? "" : ($pageNumber + 1),
            'prev' => (($pageNumber - 1) <= 0) ? "" : ($pageNumber - 1)
        ];

        foreach ($links as &$link){
            if($link){
                $params['page']['number'] = $link;
                $link = $this->buildUrl($params);
            }
        }

        $data = [
            "data" => $service->getCollection($filters, [
                'offset' => $pageNumber ? (($pageNumber - 1) * $pageSize) : 0,
                'limit' => $pageSize,
                'order' => $this->getOrder()
            ]),
        ];

        if($this->includeLinks){
            $data['links'] = $links;
        }

        if($this->includeAdditionalEntities())
            $data['includeEntities'] = $service->getAdditionalEntities($filters);

        return ResponsesJson::response($data);
    }

    protected function csvResponse($filters = [])
    {
        $csvLine = '';
        $service = new $this->nameDataService();
        $csvData = $service->getCsvData($filters);

        foreach ($csvData as $item){
            $formatter = Formatter::make($item, Formatter::ARR);
            $csvLine .= $formatter->toCsv();
        }
        return ResponsesCsv::response($csvLine);
    }

    protected function buildUrl($params)
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $uri);
        $uri = str_replace('//', '/', $uri[0]);
        $url = http_build_query($params, '', '&');
        $url = str_replace('%5D', ']', $url);
        $url = str_replace('%5B', '[', $url);
        return (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http') . '://' . $_SERVER['HTTP_HOST'] . $uri . '?' . $url;
    }

    protected function includeAdditionalEntities()
    {
        return $this->getRequest()->get('includeAdditionalEntities');
    }
}
