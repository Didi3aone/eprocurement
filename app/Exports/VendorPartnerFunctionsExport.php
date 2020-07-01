<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorPartnerFunctions;

class VendorPartnerFunctionsExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorPartnerFunctions::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Partner Functions';
    }
}