<?php
namespace App\Http\Responses;

use App\Exceptions\Error;

class Json extends Responses
{
    public static function ok()
    {
        $response = response()->json([], 200);
        $response->setContent("");
        $response->setStatusCode(200);
        $response->header('Content-Type', 'application/json');
        $response->header('charset', 'utf-8');
        return $response;
    }

    public static function response(array $data = ["data" => []], $status = 200)
    {
        $response = response()->json($data, $status);
        $response->header('Content-Type', 'application/json');
        $response->header('charset', 'utf-8');
        return $response;
    }

    public static function errors(array $errors = [], $status = 400)
    {
        return self::response([
            'errors' => $errors
        ], $status);
    }

    public static function error(Error $error)
    {
        return self::response([
            'errors' => [[
                "title" => "",
                "details" => "",
                "status" => $error->getCode()
            ]]
        ], $error->getCode());
    }

    public static function err($error)
    {
        return self::response([
            'errors' => [[
                "code" => $error->getErrorCode(),
                "target" => $error->getErrorTarget(),
                "meta" => $error->getErrorMeta()
            ]]
        ], $error->getErrorStatus());
    }
}
