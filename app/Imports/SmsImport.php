<?php


namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SmsImport implements ToArray, WithHeadingRow
{
    public function Array(Array $tables)
    {
        return [
            'phone' => $tables[0],
            'status' => $tables[1],
            'code' => $tables[2],
            'stime' => $tables[3],
        ];
    }
}
