<?php

namespace App\Imports;

use App\Models\Plant;
use Maatwebsite\Excel\Concerns\ToModel;

class PlantImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Plant([
            'code' => $row[0],
            'description' => $row[1],
        ]);
    }
}
