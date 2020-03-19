<?php

namespace App\Imports;

use App\Models\ProfitCenter;
use Maatwebsite\Excel\Concerns\ToModel;

class ProfitCenterImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProfitCenter([
            'code' => $row[0],
            'name' => $row[1],
            'small_description' => $row[2],
            'description' => $row[3],
        ]);
    }
}
