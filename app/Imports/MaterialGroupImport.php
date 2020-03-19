<?php

namespace App\Imports;

use App\Models\MaterialGroup;
use Maatwebsite\Excel\Concerns\ToModel;

class MaterialGroupImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MaterialGroup([
            'language' => $row[0],
            'code' => $row[1],
            'description' => $row[2],
        ]);
    }
}
