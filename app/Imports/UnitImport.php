<?php

namespace App\Imports;

use App\Models\MasterUnit;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UnitImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $unit = MasterUnit::where('uom', $row[1])->first();

            if (empty($unit)) {
                MasterUnit::create([
                    'uom' => $row[0],
                    'iso' => $row[1],
                    'text' => $row[2],
                ]);
            }
        }
    }
}