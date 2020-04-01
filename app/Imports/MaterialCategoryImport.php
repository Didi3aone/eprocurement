<?php

namespace App\Imports;

use App\Models\MaterialCategory;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MaterialCategoryImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $material_category = MaterialCategory::where('code', $row[1])->first();

            if (empty($material_category)) {
                MaterialCategory::create([
                    'code' => $row[0],
                    'description' => $row[1],
                ]);
            }
        }
    }
}