<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\VendorCompanyData;

class VendorCompanyDataExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return VendorCompanyData::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Company Data';
    }
}