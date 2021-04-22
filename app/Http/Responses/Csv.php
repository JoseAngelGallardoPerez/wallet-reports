<?php
namespace App\Http\Responses;

class Csv extends Responses
{
    public static function response($csvLine = '')
    {
        return response()->make($csvLine, 200, [
            'Content-Disposition' => 'attachment; filename="export.csv"',
            'Cache-control' => 'private',
            'Content-type' => 'application/force-download',
            'Content-transfer-encoding' => 'binary\n'
        ]);
    }
}
