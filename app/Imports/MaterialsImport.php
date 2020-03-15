<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;

class MaterialsImport implements ToModel
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

        return new Material([
            'code' => $row[0],
            'type' => $row[1],
            'group' => $row[2],
            'unit' => $row[3],
            'name' => $row[4],
            'description' => $row[5],
            'departemen_peminta' => 1,
            'status' => 1
        ]);
    }
}
