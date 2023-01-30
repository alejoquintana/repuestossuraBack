<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Product::create([
            'code' => $row[0],
            'name' => $row[1],
            'price' => $row[2],
            ]);
        }
    }
}