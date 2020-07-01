<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorTaxNumbers;

class VendorTaxNumbersExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorTaxNumbers::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Tax Numbers';
    }
}