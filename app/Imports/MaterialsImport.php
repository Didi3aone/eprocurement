<?php

namespace App\Imports;

use App\Models\MasterMaterial;
use Maatwebsite\Excel\Concerns\ToModel;

class MaterialsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $model = MasterMaterial::where('code', $row[0])->first();

        if (empty($model)) {
            return new MasterMaterial([
                'code' => $row[0],
                'description' => $row[1],
                'plant_code' => $row[2],
                'material_type_code' => $row[3],
                'uom_code' => $row[4],
                'purchasing_group_code' => $row[5],
                'storage_location_code' => $row[6],
                'material_group_code' => $row[7],
                'profit_center_code' => $row[8]
            ]);
        }
    }
}
