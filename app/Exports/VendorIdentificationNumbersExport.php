<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorIdentificationNumbers;

class VendorIdentificationNumbersExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorIdentificationNumbers::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Identification Numbers';
    }
}