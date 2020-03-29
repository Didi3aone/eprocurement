<?php

namespace App\Imports;

use App\Models\Asset;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AssetImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $asset = Asset::where('code', $row[1])->first();

            if (empty($asset)) {
                Asset::create([
                    'company_id' => $row[0],
                    'code' => $row[1],
                    'description' => $row[2],
                ]);
            }
        }
    }
}