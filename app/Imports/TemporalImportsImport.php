<?php

namespace App\Imports;

use App\TemporalImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ToCollection;

class TemporalImportsImport implements ToCollection, WithCustomCsvSettings
{
    public function getCsvSettings(): array
    {
    return [
        'input_encoding' => 'UTF-7'
        ];
    }
    
    public function collection(Collection $rows)
    {
        TemporalImport::truncate();
        foreach ($rows as $row) {
            TemporalImport::create([
                'col1' => isset($row[0]) ? trim($row[0]) : '',
                'col2' => isset($row[1]) ? trim($row[1]) : '',
                'col3' => isset($row[2]) ? trim($row[2]) : '',
                'col4' => isset($row[3]) ? trim($row[3]) : '',
                'col5' => isset($row[4]) ? trim($row[4]) : '',
                'col6' => isset($row[5]) ? trim($row[5]) : '',
                'col7' => isset($row[6]) ? trim($row[6]) : '',
                'col8' => isset($row[7]) ? trim($row[7]) : '',
                'col9' => isset($row[8]) ? trim($row[8]) : '',
                'col10' => isset($row[9]) ? trim($row[9]) : '',
            ]);
        }
    }
}
