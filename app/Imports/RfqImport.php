<?php

namespace App\Imports;

use App\Models\Rfq;
use Maatwebsite\Excel\Concerns\ToModel;

class RfqImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rfq([
            'code' => $row[0],
            'description' => $row[1],
        ]);
    }
}
