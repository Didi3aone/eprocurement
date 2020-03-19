<?php

namespace App\Imports;

use App\Models\MaterialType;
use Maatwebsite\Excel\Concerns\ToModel;

class MaterialTypeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MaterialType([
            'code' => $row[0],
            'description' => $row[1],
        ]);
    }
}
