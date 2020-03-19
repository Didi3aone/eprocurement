<?php

namespace App\Imports;

use App\Models\PurchasingGroup;
use Maatwebsite\Excel\Concerns\ToModel;

class PurchasingGroupImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PurchasingGroup([
            'code' => $row[0],
            'description' => $row[1],
        ]);
    }
}
