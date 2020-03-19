<?php

namespace App\Imports;

use App\Imports\MaterialGroupImport;
use App\Imports\MaterialTypeImport;
use App\Imports\PlantImport;
use App\Imports\PurchasingGroupImport;
use App\Imports\ProfitCenterImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MaterialSheet implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            0 => null, // new MaterialImport(),
            1 => null, // new MaraImport(),
            2 => new MaterialGroupImport(),
            3 => new MaterialTypeImport(),
            4 => new PlantImport(),
            5 => new PurchasingGroupImport(),
            6 => new ProfitCenterImport(),
        ];
    }
}