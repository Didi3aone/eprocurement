<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\MaterialGroup;
use App\Models\MaterialType;
use App\Models\Plant;
use App\Models\PurchasingGroup;
use App\Models\ProfitCenter;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MaterialImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $material = Material::where('code', $row[3])->first();

            if (empty($material)) {
                $mg = MaterialGroup::where('code', $row[3])->first();
                $mg = isset($mg) ? $mg->id : 0;

                $mt = MaterialType::where('code', $row[5])->first();
                $mt = isset($mt) ? $mt->id : 0;

                $pl = Plant::where('code', $row[7])->first();
                $pl = isset($pl) ? $pl->id : 0;

                $pg = PurchasingGroup::where('code', $row[9])->first();
                $pg = isset($pg) ? $pg->id : 0;

                $pc = ProfitCenter::where('code', $row[11])->first();
                $pc = isset($pc) ? $pc->id : 0;

                Material::create([
                    'code' => $row[0],
                    'small_description' => $row[1],
                    'description' => $row[2],
                    'm_group_id' => $mg,
                    'm_type_id' => $mt,
                    'm_plant_id' => $pl,
                    'm_purchasing_id' => $pg,
                    'm_profit_id' => $pc,
                ]);
            }
        }
    }
}