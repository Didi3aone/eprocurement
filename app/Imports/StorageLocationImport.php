<?php

namespace App\Imports;

use App\Models\StorageLocation;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StorageLocationImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $storageLocation = StorageLocation::where('code', $row[0])->first();

            if (empty($storageLocation)) {
                StorageLocation::create([
                    'code' => $row[0],
                    'status' => $row[1],
                    'description' => $row[2],
                ]);
            }
        }
    }
}