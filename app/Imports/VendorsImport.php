<?php

namespace App\Imports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;

class VendorsImport implements ToModel
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

        return new Vendor([
            'code' => $row[0],
            'name' => $row[1],
            'city' => $row[2],
            'district' => $row[3],
            'postal_code' => $row[4],
            'street' => $row[5],
            'title' => $row[8],
            'tax' => $row[9],
            'phone' => $row[10],
            'fax' => $row[11],
            'departemen_peminta' => 1,
            'status' => 1
        ]);
    }
}
