<?php

namespace App\Imports;

use App\Models\MasterPph;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PphImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MasterPph::create([
                'country_key' => $row[0],
                'withholding_tax_type' => $row[1],
                'withholding_tax_code' => $row[2],
                'withholding_tax_rate' => $row[3],
                'name' => $row[4]
            ]);
        }
    }
}