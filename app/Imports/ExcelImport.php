<?php

namespace App\Imports;

use App\Models\audiosexcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToCollection, WithHeadingRow
{
    
    public function collection(Collection $rows)
    {
        dd($rows);
    }
}
