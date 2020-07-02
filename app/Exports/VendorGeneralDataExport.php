<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Vendor\UserVendors;

class VendorGeneralDataExport implements FromCollection, WithTitle
{
    /**
     * @return Builder
     */

    public function collection()
    {
        return UserVendors::get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'General Data';
    }
}