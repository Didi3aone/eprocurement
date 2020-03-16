<?php

namespace App\Imports;

use App\Models\Cost;
use Maatwebsite\Excel\Concerns\ToModel;

class CostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        return new Cost([
            'area' => $row[0],
            'cost_center' => $row[1],
            'company_code' => $row[2],
            'profit_center' => $row[3],
            'hierarchy_area' => $row[4],
            'name' => $row[5],
            'description' => $row[6],
            'short_text' => $row[7],
        ]);
    }
}
