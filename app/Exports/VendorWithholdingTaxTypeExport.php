<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorWithholdingTaxType;

class VendorWithholdingTaxTypeExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorWithholdingTaxType::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Withholding Tax Data';
    }
}